
        	<div><?=mbmShowBanner('home_1');?></div>
        	<div class="titleY">NEWS</div>
       	    <div class="contentY">
            	<?=mbmContentNews($GLOBALS['htmls_normal'],mbmSubmenusInArray(mbmShowByLang(array('mn'=>7,'en'=>8888))),1,5,'date_added','desc',0,1);?>
            </div>
        	<div style="position:relative; display:block;">
  <div style="float:right; width:258px; display:block;">
                    <div class="titleY">SPORT</div>
                    <div class="contentY" style="height:300px;">
                    	<?=mbmContentNews($GLOBALS['htmls_normal'],mbmSubmenusInArray(mbmShowByLang(array('mn'=>20,'en'=>8888))),1,5,'date_added','desc',0,1);?>
                    </div>
                </div>
  <div style="float:left; width:258px; display:block;">
                    <div class="titleY">MUSIC</div>
                    <div class="contentY" style="height:300px;">
                    	 <?=mbmContentNews($GLOBALS['htmls_normal'],mbmSubmenusInArray(mbmShowByLang(array('mn'=>1,'en'=>8888))),1,5,'date_added','desc',0,1);?>
                    </div>
                </div>
          	  <br clear="all" />
            </div>
        	<div class="titleY">CLUB LIFE</div>
       	    <div class="contentY">
            	<?=mbmContentNews($GLOBALS['htmls_normal'],mbmSubmenusInArray(mbmShowByLang(array('mn'=>26,'en'=>8888))),1,5,'date_added','desc',0,1);?>
            </div>
            <div style="margin-top:3px; display:none;"><img src="templates/freedom2/images/tmp2.jpg" width="519" height="148" /></div>