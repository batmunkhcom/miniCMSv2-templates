<?
$q_topmenus = "SELECT * FROM ".PREFIX."menus WHERE st='1' AND lev<='".$_SESSION['lev']."' AND menu_id='0' ORDER BY pos";
$r_topmenus = $DB->mbm_query($q_topmenus);

$_top = '<div id="topMenus">';

$t_menus=0;
for($i=0;$i<$DB->mbm_num_rows($r_topmenus);$i++){
	$t_menus++;
	
	if($i>0){
		$onclick_mainmenu = ' onclick="return false;"';
	}
	$_top .= ''
			 .'<a href="'.mbmMenuLink($DB->mbm_result($r_topmenus,$i,"id"),$DB->mbm_result($r_topmenus,$i,"link")).'" '
			 .'onmouseover="mbmShowTopSubmenu('.$i.');" '
			 .'id="topmenu'.$i.'" class="" '
			 .$onclick_mainmenu 
			 .'>'
			 .$DB->mbm_result($r_topmenus,$i,"name")
			 .'</a>';
	$_top1 .= '<div id="topMenu'.$i.'" style="display:none;" '
			// .'onMouseOver="document.getElementById(\'topmenu'.$i.'\').style.className=\'topmenu_active_shuu\'" '
			  .'>'
			  .mbmShowMenuById(array('',' | '),$DB->mbm_result($r_topmenus,$i,"id"),'top_submenus')
			  .'</div>';
	if($DB->mbm_get_field(MENU_ID,'id','menu_id','menus')==$DB->mbm_result($r_topmenus,$i,"id") || $DB->mbm_result($r_topmenus,$i,"id")==MENU_ID){
		$make_active_topmenu = $i;
	}
}
$_top1 .= '<script language="Javascript">';
$_top1 .= '
			function mbmShowTopSubmenu(id){
				for(i=0;i<'.$t_menus.';i++){
					//document.getElementById(\'topMenu\'+i).style.display=\'none\';
					$("#topMenu"+i).hide(10);
					//$("#topMenu"+i).fadeOut(500);
					$("#topmenu"+i).removeClass("topmenu_active_shuu");
				}
				$("#topmenu"+id).addClass("topmenu_active_shuu");
				$("#topMenu"+id).show("fast");
				//$("#topMenu"+id).fadeIn(500);
				/*
				alert($("#topMenu"+id+" .top_submenus").size());
				$("#topMenu"+id+" .top_submenus").each(fucntion(){
												$(this).show("fast");				
																});
				*/
			}'."\n";
		$_top1 .= 'mbmShowTopSubmenu('.$make_active_topmenu.'); ';
$_top1 .= '</script>';
$_top .= '</div>';

	$htmls_video[0] = '<table width="100%" cellpadding="3" cellspacing="2" border="0"><tr>';
	$htmls_video[2] = '<td align="center" width="25%" valign="top">';
	$htmls_video[3] = '</td>';
	$htmls_video[1] = '</tr></table>';
	
	$htmls_normal[0] = '<ul>';
	$htmls_normal[2] = '<li style="margin-bottom:6px;">';
	$htmls_normal[3] = '</li>';
	$htmls_normal[1] = '</ul>';
	
	
	
function mbmShowContentPhotosWallpapers(){
	global $DB,$lang;
	
	$q_photos = "SELECT * FROM ".PREFIX."menu_photos ";
	if(MENU_ID != 0 ){
		$q_photos .= "WHERE content_id IN (SELECT id FROM ".PREFIX."menu_contents WHERE st='1' AND lev<='".$_SESSION['lev']."' AND menu_id LIKE '%,".MENU_ID.",%') ";
	}
	if(!isset($_GET['ob'])){
		$order_by = 'date_added';
	}else{
		$order_by = $_GET['ob'];
		$query_string .= '&ob='.$_GET['ob'];
	}
	if(!isset($_GET['asc'])){
		$asc = 'desc';
	}else{
		$asc = $_GET['asc'];
		$query_string .= '&asc='.$_GET['asc'];
	}
	$q_photos .= " ORDER BY ".$order_by." ".$asc;
	$r_photos = $DB->mbm_query($q_photos);
	
	if((START+PER_PAGE_CONTENTS) > $DB->mbm_num_rows($r_photos)){
		$end= $DB->mbm_num_rows($r_photos);
	}else{
		$end= START+PER_PAGE_CONTENTS; 
	}
	
	$paging = mbmNextPrev('index.php?menu_id='.MENU_ID.$query_string,$DB->mbm_num_rows($r_photos),START,PER_PAGE_CONTENTS);
	
	$buf = '';
	
	$buf .= $paging;
	
	$buf .= '<div id="thumbPhotos" style="display:block;clear:both;">';
	
	$k=0; //for adsense
	$google_add = '';
	$google_add .= '<br clear="both" />';
	$google_add .= '<div style="text-align:center;">';
		$google_add .= '<script type="text/javascript"><!--
				google_ad_client = "pub-3377050199087606";
				/* 728x90, created 12/16/07 */
				google_ad_slot = "0477445965";
				google_ad_width = 728;
				google_ad_height = 90;
				//-->
				</script>
				<script type="text/javascript"
				src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
				</script>';
	$google_add .= '</div>';
	$google_add .= '<br clear="both" />';
	for($i=START;$i<$end;$i++){
	//for($i=0;$i<$DB->mbm_num_rows($r_photos);$i++){
		if(substr_count($DB->mbm_result($r_photos,$i,"url"),DOMAIN.DIR)>0){
			$img_url = str_replace(DOMAIN.DIR,"",$DB->mbm_result($r_photos,$i,"url"));
		}else{
			$img_url = $DB->mbm_result($r_photos,$i,"url");
		}
		if($DB->mbm_result($r_photos,$i,"width")<NEWS_PHOTO_WIDTH){
			$photo_w = $DB->mbm_result($r_photos,$i,"width");
		}else{
			$photo_w = NEWS_PHOTO_WIDTH;
		}
		$image_url_full = ''.DOMAIN.DIR.'img.php?type='
					.$DB->mbm_result($r_photos,$i,'filetype')
					.'&amp;f='
					.base64_encode($img_url)
					.'&w='
					.$photo_w;
		
		$image_download_url = DOMAIN.DIR.'rss.php?dl=content_photo&id='.$DB->mbm_result($r_photos,$i,'id');
		
		$buf1 .= '<span class="imageTitle'.$DB->mbm_result($r_photos,$i,"id").'" ><strong>'
				.$DB->mbm_result($r_photos,$i,"title").'</strong></span>';
		$buf .= '<a href="'.$image_url_full.'" title="'.$DB->mbm_result($r_photos,$i,"comment").'" downloadUrl="'.$image_download_url.'">';
		$buf .= $DB->mbm_result($r_photos,$i,"title").'<br />';
			
			$buf .= '<img border="0" src="'.DOMAIN.DIR.'img.php?type='
						.$DB->mbm_result($r_photos,$i,'filetype')
						.'&amp;f='
						.base64_encode($img_url)
						.'&w=80&h=80'
						.'" align="absmiddle"';
			$buf .='" class="thumb_img"  alt="'.$DB->mbm_result($r_photos,$i,"comment").'a" bigImg="'.$image_download_url.'" />';
		$buf .= '</a>';
		$buf1 .= '<div class="imageComment'.$DB->mbm_result($r_photos,$i,"id").'" >'
				.$DB->mbm_result($r_photos,$i,"comment").'</div>';
		$buf1 .= '<a href="'.$image_download_url.'" class="imageDownload" target="_blank">'.$lang["menu"]["photo_orig_size"].'</a>';
		
		$DB->mbm_query("UPDATE ".PREFIX."menu_photos SET hits=hits+".HITS_BY.",session_time='".mbmTime()."' WHERE id='".$DB->mbm_result($r_photos,$i,"id")."'");
		
		if(($i%30)==29 && $k<3){
			$k++;
			$buf .= $google_add;
		}
	}
	if($k<31){
		$buf .= $google_add;
	}
	$buf .= "</div><br clear='both' />";
	
	$buf .= $paging;
	
	return $buf;
}
?><link href="templates/suudercom/css/main.css" rel="stylesheet" type="text/css" />
<link href="templates/suudercom/css/suudercom.css" rel="stylesheet" type="text/css" />
<table width="935" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="95" >
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td><h1>Wallpapers.az.mn</h1></td>
          <td valign="top">&nbsp;</td>
          <td width="200" valign="top" style="color:#FFF;">
          <?
          	$q_total_wpapers = "SELECT COUNT(id),SUM(filesize) FROM ".PREFIX."menu_photos";
			$r_total_wpapers = $DB->mbm_query($q_total_wpapers);
			
			echo 'Нийт <strong>'.mbmFileSizeMB($DB->mbm_result($r_total_wpapers,0,1)).'</strong> хэмжээ бүхий <strong>'.$DB->mbm_result($r_total_wpapers,0,0).'</strong> зураг байна.';
		  ?>
          </td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td bgcolor="#333">
    <?
              mbmMenuListById(array(
									'menu_id'=>390,
									'lev'=>0,
									'st'=>1,
									'mainCatClass'=>'topMenu',
									'subCatClass'=>'topMenuSub'
									));
			echo $_top;
			?>
	<div id="topSubmenu">
	<?=$_top1?>
    </div>
    </td>
  </tr>
  <tr>
    <td height="10" bgcolor="#FFFFFF" class="bg_repeatx" style="background-image:url(templates/suudercom/images/menu_footer_bg.jpg);"></td>
  </tr>
  <tr>
    <td style="padding-left:7px; padding-right:7px; background-color:#FFF;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td valign="top">
        	<?
            if(strlen($_SERVER['QUERY_STRING'])<5){
				echo '<div class="talbar">'.mbmShowBanner('home_1').'</div>';
			}
			?>
        	<div class="talbar" style="text-align:center;">
             <?
				if($_GET['cmd']!='monthly') {
					echo mbmShowContentPhotosWallpapers();
				}else{
					if(file_exists(ABS_DIR."modules/".$_GET['module']."/".$_GET['cmd'].".php")){
						mbm_include_file("modules/".$_GET['module']."/".$_GET['cmd'].".php");
					}else{
						//include_once(ABS_DIR."templates/".TEMPLATE."/home.php");
					}
				}
			 ?>
            </div>
        </td>
        <?
        if(isset($_GET['menu_id']) && !isset($_GET['id'])){
			//echo '<td width="2" valign="top">&nbsp;</td>';
			//echo '<td width="130" align="center" valign="top">&nbsp;</td>';
		}
		?>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="40" align="right" style="color:#FFF;"><?=mbmShowMenuById(array(' | ','','',' | '),450,'menu_footer').mbmStatImage().COPYRIGHT;?></td>
  </tr>
</table>
