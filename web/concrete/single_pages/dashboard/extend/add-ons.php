<?
defined('C5_EXECUTE') or die("Access Denied.");
$valt = Loader::helper('validation/token');
$ci = Loader::helper('concrete/urls');
$ch = Loader::helper('concrete/interface');
$tp = new TaskPermission();
if ($tp->canInstallPackages()) {
	$mi = Marketplace::getInstance();
}
?>

<div class="ccm-ui">
<div class="row">


<? if ($_GET['_ccm_dashboard_external']) { ?>
	<div class="newsflow" id="newsflow-main" style="height: auto; overflow: visible">
	<ul class="ccm-pane-header-icons">
		<li><a href="javascript:void(0)" onclick="ccm_closeNewsflow()" class="ccm-icon-close"><?=t('Close')?></a></li>
	</ul>
<? } else { ?>
	<div class="ccm-pane" id="ccm-marketplace-item-browser">
	<?=Loader::helper('concrete/dashboard')->getDashboardPaneHeader(t('Browse Add-Ons'), t('Get more add-ons from concrete5.org.'));?>
<? } ?>
<div class="ccm-pane-body" id="ccm-marketplace-detail">
<div id="ccm-marketplace-detail-inner"></div>
<? if ($list->getTotal() > 0) { ?>
<p class="ccm-marketplace-detail-loading"><?=t('Loading Details')?></p>
<? } else { ?>
	<p><?=t('No results found.')?></p>
<? } ?>


<? if ($pagination->hasPreviousPage()) { ?>
	<div class="newsflow-paging-previous"><a href="javascript:void(0)" onclick="ccm_marketplaceBrowserSelectPrevious()"><span></span></a></div>
<? } ?>
<? if ($pagination->hasNextPage()) { ?>
	<div class="newsflow-paging-next"><a href="javascript:void(0)" onclick="ccm_marketplaceBrowserSelectNext()"><span></span></a></div>
<? } ?>
</div>

<div class="ccm-pane-options">
<div class="ccm-pane-options-permanent-search">
<form id="ccm-marketplace-browser-form" method="get" action="<?=$this->url('/dashboard/extend/add-ons')?>">
	<?=Loader::helper('form')->hidden('_ccm_dashboard_external')?>
	<div class="span4">
	<?=$form->label('marketplaceRemoteItemKeywords', t('Keywords'))?>
	<div class="input">
		<?=$form->text('marketplaceRemoteItemKeywords', array('style' => 'width: 140px'))?>
	</div>
	</div>
	
	<div class="span4">
	<?=$form->label('marketplaceRemoteItemSetID', t('Category'))?>
	<div class="input">
	<?=$form->select('marketplaceRemoteItemSetID', $sets, $selectedSet, array('style' => 'width: 150px'))?>
	</div>
	</div>

	<div class="span4">
	<?=$form->label('marketplaceRemoteItemSortBy', t('Sort By'))?>
	<div class="input">
	<?=$form->select('marketplaceRemoteItemSortBy', $sortBy, $selectedSort, array('style' => 'width: 150px'))?>
	</div>
	</div>
	
	<div class="span2">
		<?=$form->submit('submit', t('Search'))?>
	</div>
</form>	
</div>
</div>

<div class="ccm-pane-body">
	
		<table class="ccm-marketplace-results">
			<tr>
			<?php 
			$numCols=3;
			$colCount=0;
			$i = 0;
			foreach($items as $item){ 
				if($colCount==$numCols){
					echo '</tr><tr>';
					$colCount=0;
				}
				?>
				<td valign="top" width="33%" mpID="<?=$item->getMarketplaceItemID()?>" class="ccm-marketplace-item <? if ($_REQUEST['mpID'] == $item->getMarketplaceItemID() || ($i == 0 && (!$_REQUEST['prev'])) || $i == 2 && $_REQUEST['prev']) { ?>ccm-marketplace-item-selected<? } else { ?>ccm-marketplace-item-unselected<? } ?>"> 
				
				<img class="ccm-marketplace-item-thumbnail" width="44" height="44" src="<?php echo $item->getRemoteIconURL() ?>" />
				<div class="ccm-marketplace-results-info">
					<h4><?=$item->getName()?></h4>
					<h5><?=((float) $item->getPrice() == 0) ? t('Free') : $item->getPrice()?></h5>
					<p><?php echo $item->getDescription() ?></p>
				</div>
					
				</td>
			<?php   $colCount++;
			$i++;
			}
			for($i=$colCount;$i<$numCols;$i++){
				echo '<td>&nbsp;</td>'; 
			} 
			?>
			</tr>
		</table>
</div>

<? $url = Loader::helper('url')->unsetVariable('prev'); ?>
<div class="ccm-pane-footer" id="ccm-marketplace-browse-footer"><?=$list->displayPagingV2($url)?></div>

</div>

</div>
</div>

<? if (!$_REQUEST['_ccm_dashboard_external']) { ?>
<script type="text/javascript">
$(function() {
	ccm_marketplaceBrowserInit(); 
});
</script>
<? } ?>