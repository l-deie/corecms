<?php
class cpPdomysql {
	private $_writeLink = NULL; //主
	private $_readLink = NULL; //从
	private $affectedRows = 0; //受影响条数
	private $_replication = false; //标志是否支持主从
	private $dbConfig = array();
	public $sql = "";

	public function __construct($dbConfig = array()){
		$this->dbConfig = $dbConfig;
		//判断是否支持主从
		$this->_replication = isset($this->dbConfig['DB_SLAVE']) && !empty($this->dbConfig['DB_SLAVE']);
	}

	//执行sql查询
	public function query($sql, $params = array()) {
		foreach($params as $k => $v){
			$sql = str_replace(':'.$k, $this->escape($v), $sql);
		}
		$this->sql = $sql;
		try {
			$query = $this->_getReadLink()->query($sql);
			return $query;
		}catch (PDOException $e){
			$errorInfo = $this->_getReadLink()->errorInfo();//取得错误信息数组
			$errorCode = $errorInfo[1];
			$errorMsg = $errorInfo[2];
			$this->error('MySQL Query Error', $errorMsg, $errorCode);
		}
	}

	//执行sql命令
	public function execute($sql, $params = array()) {
		foreach($params as $k => $v){
			$sql = str_replace(':'.$k, $this->escape($v), $sql);
		}
		$this->sql = $sql;
		try {
			$query = $this->_getWriteLink()->exec($sql);
			$this->affectedRows = $query;//用于affectedRows()获取返回结果
			return $query;
		}catch (PDOException $e){
			$errorInfo = $this->_getReadLink()->errorInfo();//取得错误信息数组
			$errorCode = $errorInfo[1];
			$errorMsg = $errorInfo[2];
			$this->error('MySQL Query Error', $errorMsg, $errorCode);
		}

	}

	//从结果集中取得一行作为关联数组，或数字数组，或二者兼有
	public function fetchArray($query, $result_type = PDO::FETCH_ASSOC) {
		return  $query->fetch($result_type);
	}

	//取得前一次 MySQL 操作所影响的记录行数
	public function affectedRows() {
		return $this->affectedRows ? $this->affectedRows : true;
	}

	//获取上一次插入的id
	public function lastId() {
		return $this->_getWriteLink()->lastInsertId();
	}
	//获取数据库表
	public function getTables($database){
		$this->sql = "SHOW TABLES FROM `{$database}`";
		$query = $this->query($this->sql);
		$data = array();
		while($row = $this->fetchArray($query)){
			$data[] = $row['Tables_in_'.$this->dbConfig['DB_NAME']];;
		}
		return $data;
	}
	//获取表结构
	public function getFields($table) {
		$this->sql = "SHOW FULL FIELDS FROM {$table}";
		$query = $this->query($this->sql);
		$data = array();
		while($row = $this->fetchArray($query)){
			$data[] = $row;
		}
		return $data;
	}

	//获取行数
	public function count($table,$where) {
		$this->sql = "SELECT count(*) FROM $table $where";
		$query = $this->query($this->sql);
		return $query->fetchColumn();
	}

	//数据过滤
	public function escape($value) {
		if( isset($this->_readLink) ) {
			$mysqli = $this->_readLink;
		} elseif( isset($this->_writeLink) ) {
			$mysqli = $this->_writeLink;
		} else {
			$mysqli = $this->_getReadLink();
		}

		if( is_array($value) ) {
			return array_map(array($this, 'escape'), $value);
		} else {
			return "'" . addslashes($value) . "'";
		}
	}


	//解析待添加或修改的数据
	public function parseData($options, $type) {
		//如果数据是字符串，直接返回
		if(is_string($options['data'])) {
			return $options['data'];
		}
		if( is_array($options) && !empty($options) ) {
			switch($type){
				case 'add':
					$data = array();
					$data['fields'] = array_keys($options['data']);
					$data['values'] = $this->escape( array_values($options['data']) );
					return " (`" . implode("`,`", $data['fields']) . "`) VALUES (" . implode(",", $data['values']) . ") ";
				case 'save':
					$data = array();
					foreach($options['data'] as $key => $value) {
						$data[] = " `$key` = " . $this->escape($value);
					}
					return implode(',', $data);
				default:return false;
			}
		}
		return false;
	}

	//解析查询条件
	public function parseCondition($options) {
		$condition = "";
		if(!empty($options['where'])) {
			$condition = " WHERE ";
			if(is_string($options['where'])) {
				$condition .= $options['where'];
			} else if(is_array($options['where'])) {
				foreach($options['where'] as $key => $value) {
					//如果有$where[1]="id='f'"则不进行方过滤处理需要在取得变量时进行方过滤处理
					$condition .= is_numeric($key) ? $value . " AND " : " `$key` = " . $this->escape($value) . " AND ";
				}
				$condition = substr($condition, 0,-4);
			} else {
				$condition = "";
			}
		}

		if( !empty($options['group']) && is_string($options['group']) ) {
			$condition .= " GROUP BY " . $options['group'];
		}
		if( !empty($options['having']) && is_string($options['having']) ) {
			$condition .= " HAVING " .  $options['having'];
		}
		if( !empty($options['order']) && is_string($options['order']) ) {
			$condition .= " ORDER BY " .  $options['order'];
		}
		if( !empty($options['limit']) && (is_string($options['limit']) || is_numeric($options['limit'])) ) {
			$condition .= " LIMIT " .  $options['limit'];
		}
		if( empty($condition) ) return "";
		return $condition;
	}

	//输出错误信息
	public function error($message = '',$error = '', $errorno = ''){
		if( DEBUG ){
			$error_sql = str_replace(cpConfig::get('DB_PREFIX'),'[PRE]',$this->sql);
			$error = str_replace(cpConfig::get('DB_PREFIX'),'[PRE]',$error);
			$str = " {$message}<br>
					<b>SQL</b>: {$error_sql}<br>
					<b>错误详情</b>: {$error}<br>
					<b>错误代码</b>:{$errorno}<br>"; 
		} else {
			$str = "<b>出错</b>: $message<br>";
		}
		throw new Exception($str);
	}

	//获取从服务器连接
	private function _getReadLink() {
		if( isset( $this->_readLink ) ) {
			//$this->_readLink->ping();
			return $this->_readLink;
		} else {
			if( !$this->_replication ) {
				return $this->_getWriteLink();
			} else {
				$this->_readLink = $this->_connect( false );
				return $this->_readLink;
			}
		}
	}

	//获取主服务器连接
	private function _getWriteLink() {
		if( isset( $this->_writeLink ) ) {
			//$this->_writeLink->ping();
			return $this->_writeLink;
		} else{
			$this->_writeLink = $this->_connect( true );
			return $this->_writeLink;
		}
	}

	//数据库链接
	private  function _connect($is_master = true) {
		if( ($is_master == false) && $this->_replication ) {
			$slave_count = count($this->dbConfig['DB_SLAVE']);
			//遍历所有从机
			for($i = 0; $i < $slave_count; $i++) {
				$db_all[] = array_merge($this->dbConfig, $this->dbConfig['DB_SLAVE'][$i]);
			}
			$db_all[] = $this->dbConfig;//如果所有从机都连接不上，连接到主机
			//随机选择一台从机连接
			$rand =  mt_rand(0, $slave_count-1);
			$db = array_unshift($db_all, $db_all[$rand]);
		} else {
			$db_all[] = $this->dbConfig; //直接连接到主机
		}

		foreach($db_all as $db) {
			try {
				$errorCode = '00000';
				$errorMsg = '';
				$dns = "mysql:host={$db['DB_HOST']};port={$db['DB_PORT']};dbname={$db['DB_NAME']}";
				$pdo = new PDO($dns, $db['DB_USER'], $db['DB_PWD']);
				//$pdo->setAttribute(PDO::ATTR_PERSISTENT, true);  // 设置数据库连接为持久连接
				$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // 设置抛出错误
				$pdo->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);  // 指定数据库返回的NULL值在php中对应的数值 不变
				$pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_NATURAL); // 强制PDO 获取的表字段字符的大小写转换,原样使用列值
				$pdo->exec("SET NAMES {$db['DB_CHARSET']}");//设置编码
				return $pdo;
				break;
			} catch (PDOException $e) {
				//$pdo = null;
				//exit('数据库连接错误，错误信息：'. $e->getMessage());
				$errorCode = $e->getCode();
				$errorMsg =  $e->getMessage();
				continue;
			}
		}
		if($errorCode != '00000'){
			$this->error('无法连接到数据库服务器', $errorMsg, $errorCode);
		}


	}

	//关闭数据库
	public function __destruct() {
		if($this->_writeLink) {
			$this->_writeLink = NULL;
		}
		if($this->_readLink) {
			$this->_readLink = NULL;
		}
	}
}