<?php //3aug2012 ?><div id="mainCotent">
<!--content-->
	<div id="content">
	
		<div id="setContentBg">
		
			<div id="leftContent">
				<div class="topCatagoriesContainer">
					<div class="topCatagoriesImgTop">
					</div>
				<div class="topCatagoriesImgMid">
					<div class="catagoryInnerContainer">
						<div class="SchoolfeaturedHeading">
							Articals
						</div>
						<div id="articleIndex " style="padding:20px">
							<div id="loading" class="fixedCenter">	<?php echo $html->image('loading.gif'); ?></div>
							<div id="pagingDivParent">
								<?php  echo $this->renderElement('userElements/article_paging'); ?>	
							</div>	
						</div>
				</div>
				</div>
				
				<div class="topCatagoriesImgBot">
				</div>
				</div>
			<!-- start question container -->
			<!-- end question container -->
			</div>
		<!-- end left container -->
			
			  <!-- start right container -->
				<?php echo $this->renderElement('userElements/right_panel'); ?> 
	</div>
<!--content-->
</div>