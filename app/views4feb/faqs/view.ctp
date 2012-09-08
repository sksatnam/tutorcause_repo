<div id="mainCotent">
<!--content-->
	<div id="content">
	
		<div id="setContentBg">
		
			<div id="leftContent">
				<div class="topCatagoriesContainer">
					<div class="topCatagoriesImgTop">
					</div>
				
					<div class="topCatagoriesImgMid">
						<div class="catagoryInnerContainer">
							<div class="SchoolfeaturedHeading" style="float: left; width: auto;">
								Articles
							</div>
							<div id="flashmsg" style="display: block; float: right;">
													<b><?php $session->flash();?></b>
												</div>
							<div class="faqsx">
								<div class="faqanswer">
									<!-- articals -->
									<div class="articals">
										<!-- articals left -->
										<div class="articalsLeft">
											<label class="articalDay">
												<?php
													$datetime = strtotime($article_title[0]['Article']['created']);
													echo date("d", $datetime);
												?>
											</label>
											<label class="articalMonth">
											<?php
												$datetime = strtotime($article_title[0]['Article']['created']);
												echo date("F", $datetime);
											?>
											</label>
										</div>
										<!-- articals left -->
										<!-- articals right -->
										<div class="articalsRight">
											 <div class="articalRgtName">
												<?php echo strip_tags($article_title[0]['Article']['title']);?>
											 </div>
													<!-- share icon containg 490 width -->
											 <div class="articalRgtShareIcon">
												<ul>
													<li>
														<?php echo $html->link($html->Image('frontend/mail_ur_frn.png'),'javascript:void(0)', array('escape'=>false,'rel'=>'emailup'));?>
													</li>
													<li>
														<a class="addthis_button_facebook"></a>
														
														<?php //echo $html->link($html->Image('frontend/facebook_artical.png'),'', array('escape'=>false));?>
													</li>
													<li>
														<a class="addthis_button_myspace"></a>
														
														<?php //echo $html->link($html->Image('frontend/twitter_artical.png'),'', array('escape'=>false));?>
													</li>
													<li>
														<a class="addthis_button_google"></a>
														
														<?php //echo $html->link($html->Image('frontend/Add-To-Favorite.png'),'', array('escape'=>false));?>
													</li>
													<li>
														<a class="addthis_button_twitter"></a>
													
														<?php //echo $html->link($html->Image('frontend/document-print.png'),'javascript:print()', array('escape'=>false));?>
													</li>
													<li>	
														<a class="addthis_button_delicious"></a>
														<?php //echo $html->link($html->Image('frontend/addthis.png'),'', array('escape'=>false));?>
													</li>
												</ul>
											 </div>
													<?php //echo $html->link($html->Image('frontend/facebook_iLike.jpg'),'', array('escape'=>false,'class'=>'facebookiLike'));?>
													<!-- share icon containg 490 width -->
					
													<!-- artical simple text -->
													<div class="articalSimpleText">
														<?php echo strip_tags($article_title[0]['Article']['body']);?>
													</div>
											 <!-- artical simple text -->
										</div> <!-- articals right closed -->
										<div id="ajax-loading" style="display:none"><?php echo $html->image('loading.gif'); ?></div>
										<div id="pagingDivParent">
										<?php  echo $this->renderElement('userElements/article_comment_paging'); ?>
										</div>
											<!-- user comment -->
											<!-- user comment -->
										<!-- post artical box -->
										<?php if($session->read('Member.group_id') == '3'){?>
										
										<?php echo $form->create('ArticleComment',array("id"=>"ArticleCommentForm","url" => $html->url(array('controller'=>'article_comments','action'=>'add'), true))); ?> 
										<div class="postArtclBox">
											<div class="postArtclTitile">Post a comment</div>
												<?php  echo $form->input( 'article_id', array( 'value' => $articleid  , 'type' => 'hidden') ); ?>
											<div class="mceTintTxtAreaContainerBorder1">
											<?php echo $form->textarea('comment',array('class'=>'tinymce'))?>
											<?php  //echo $form->textarea('answer',array('label'=>'','class'=>'tinymce','div' => 'entryField')); ?>
											</div>
											<!--<textarea rows="5" cols="66"></textarea>-->
											<div class="articleCommentPostButton">
												<?php  echo $form->submit('frontend/post_comment.png'); ?>
											</div>
										</div>
										<!-- post artical box -->
										<!--	<a class="postComment" href="javascript:void(0);"><img src="../img/frontend/post_comment" /></a> -->
										<?php echo $form->end();?>
										<?php }?>
									
									</div>
									<!-- articals -->
										
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
