<footer>
	<div class="contact">
		
    	<div class="row"> 
    		<div class="col-md-4 col-xs-12">
	    		<h4>Classification</h4>
	    		<ul>
					<?php echo $this->showSubMenu(1);;?>
	    		</ul>
			</div>
    		
    		<div class="col-md-4 col-xs-12">
    			<h4>Contact Us</h4>
    			<p>Shanghai Vincit- Gao Industrial Co., Ltd</p>
    			<p>Email: ng@vincit-gao.com</p>
    			<p>Tel: + 86 2131116195</p>
				<p>http://www.vincit-gao.com/</p>
				<p>http://www.dredging-china.com/</p>
				<p>Add: No. 1919 Zhongshan West Road, Xuhui Dist., Shanghai, PR China</p>
    		</div>
    		
    		<div class="col-md-4 col-xs-12">
    			<h4>Follow Us</h4>
    			<div class="follows">
    				<?php Lamb_View_Tag_List::main(array(
				'sql' => 'select * from skytech_flinks',
				'include_union' => null,
				'prepare_source' => null,
				'is_page' => false,
				'page' => null,
				'pagesize' => null,
				'offset' => 0,
				'limit' => null,
				'cache_callback' => null,
				'cache_time' => null,
				'cache_type' => null,
				'cache_id_suffix' => '',
				'is_empty_cache' => null,
				'id' => null,
				'empty_str' => '<p class="nodata">No records</p>',
				'auto_index_prev' => 0,
				'db_callback' => null,
				'show_result_callback' => create_function('$item,$index','return str_replace("#autoIndex#",$index,\'
    				<a href="\'.$item[\'flink_site\'].\'"><img src="\'.$item[\'flink_logo\'].\'"></a>
    				\');')
			))?>
    			</div>
    		</div>
    		
    	</div>
		
		<a href="mailto:ng@vincit-gao.com" target="_top" class="btn btn-email">Mail us<span class="glyphicon glyphicon-chevron-right"></span></a>
		
	</div>
</footer>