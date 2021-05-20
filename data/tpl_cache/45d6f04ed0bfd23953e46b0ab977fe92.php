<?php if (!defined('TPL_INC')) exit;?><?php $cpTemplate->display("common/header"); ?> 

<div class="content"> <a href="<?php echo url('cat/index');?>" class="btn btn-blue">栏目列表</a>
  <form id="catform" method="post" action="<?php echo url('cat/add');?>">
    <p>
      <label class="required" for="parentid">上级栏目</label>      
      <br/>
      <select name="parentid" id="parentid">
        <option value="0">顶级栏目</option>
        <?php $n=1;if(is_array($cattree)) foreach($cattree AS $val) { ?>
            <option value="<?php echo $val['id']; ?>"><?php echo $val['ctitle']; ?></option>
        <?php $n++;}unset($n); ?>
      </select>
    </p>
    <p>
      <label class="required" for="parentid">数据模型</label>      
      <br/>
      <select name="model" id="model">        
        <?php $n=1;if(is_array($model)) foreach($model AS $val) { ?>
            <option value="<?php echo $val['name']; ?>"><?php echo $val['title']; ?></option>
        <?php $n++;}unset($n); ?>
      </select>
    </p>
    <p>
      <label class="required" for="title">栏目名称</label>
      <br/>
      <input class="half" type="text" value="" name="title"/>
    </p>    
    <p>
      <label for="keywords">关键字</label>
      <br/>
      <input type="text" class="full" value="" id="keywords" name="keywords"/>
    </p>
    <p>
      <label for="description">简要</label>
      <br/>
      <textarea type="text" class="full" id="description" name="description"/></textarea>
    </p>
    <p>
      <label for="template">列表模板</label>
      <br/>
      <input class="half" type="text" value="" id="template" name="template"/>
    </p>
    <p>
      <label for="vtemplate">内容模板</label>
      <br/>
      <input class="half" type="text" value="" id="vtemplate" name="vtemplate"/>
    </p>    
    <p>
      <label for="orderfield">排序</label>
      <br/>
      <input class="half" type="text" value="" id="orderfield" name="orderfield"/>
    </p> 
    <p>
      <input type="submit" class="btn btn-green big" value="添加"/>
      </p>
    <div class="clear">&nbsp;</div>
  </form>
</div>
<?php $cpTemplate->display("common/footer"); ?>