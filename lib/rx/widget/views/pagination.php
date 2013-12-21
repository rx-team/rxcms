<form id="pagerForm" method="post" action="<?php echo $pages['url']; ?>">
	<!-- <input type="hidden" name="status" value="${param.status}"> -->
	<?php
	if ( isset($pages['search']) || !empty($page['search']) ):
		foreach ( $pages['search'] as $sk => $sv ):
	?>
		<input type="hidden" name="<?php echo $sk; ?>" value="<?php echo $sv; ?>" />
	
	<?php
		endforeach;
	endif;
	?>
	<input type="hidden" name="pageNum" value="1" />
	<input type="hidden" name="numPerPage" value="<?php echo $pages['numPerPage']; ?>" />
</form>

<div class="panelBar">
	<div class="pages">
		<!-- <span>显示</span>
		<select class="combox" name="numPerPage" onchange="navTabPageBreak({numPerPage:this.value})">
			<option value="20">20</option>
			<option value="50">50</option>
			<option value="100">100</option>
			<option value="200">200</option>
		</select> -->
		<span>条，共 <?php echo $pages['totalCount']; ?> 条</span>
	</div>
	
	<div class="pagination" targetType="<?php echo $pages['targetType']; ?>" totalCount="<?php echo $pages['totalCount']; ?>" numPerPage="<?php echo $pages['numPerPage']; ?>" pageNumShown="<?php echo $pages['pageNumShown']; ?>" currentPage="<?php echo $pages['pageNum']; ?>"></div>

</div>