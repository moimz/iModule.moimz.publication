<?php
/**
 * 이 파일은 출판물관리모듈의 일부입니다. (https://www.imodule.kr)
 *
 * 출판물관리모듈 기본템플릿 (목록보기)
 * 
 * @file /modules/publication/templets/default/list.paper.php
 * @author Arzz (arzz@arzz.com)
 * @license MIT License
 * @version 3.0.0
 * @modified 2018. 2. 1.
 */
if (defined('__IM__') == false) exit;
?>
<div data-role="tabbar">
	<div>
		<ul>
			<li<?php echo $mode == 'year' ? ' class="selected"' : ''; ?>><a href="<?php echo $me->getUrl('list','year'); ?>">연도별</a></li>
			<li<?php echo $mode == 'publisher' ? ' class="selected"' : ''; ?>><a href="<?php echo $me->getUrl('list','publisher'); ?>">저널별</a></li>
			<li<?php echo $mode == 'author' ? ' class="selected"' : ''; ?>><a href="<?php echo $me->getUrl('list','author'); ?>">저자별</a></li>
		</ul>
	</div>
</div>

<div class="searchbox">
	<ul data-role="form" class="inner">
		<?php if ($mode == 'year') { ?>
		<li>
			<label>연도</label>
			<div>
				<div data-role="input">
					<select name="year">
						<?php foreach ($selectors as $selector) { ?>
						<option value="<?php echo $selector->year; ?>"<?php echo $year == $selector->year ? ' selected="selected"' : ''; ?>><?php echo $selector->year.'년도 ('.number_format($selector->count).'건)'; ?></option>
						<?php } ?>
					</select>
				</div>
			</div>
		</li>
		<?php } ?>
		
		<?php if ($mode == 'publisher') { ?>
		<li>
			<label>저널명</label>
			<div>
				<div data-role="input" data-search="<?php echo $IM->getProcessUrl('publication','searchPublisher'); ?>?type=<?php echo $type; ?>">
					<input type="search" name="publisher" placeholder="등록되어 있는 저널명이 자동검색됩니다." autocomplete="off" value="<?php echo $publisher != null ? $publisher->title : ''; ?>">
				</div>
			</div>
		</li>
		<?php } ?>
		
		<?php if ($type == 'PAPER') { ?>
		<li>
			<label>검색어</label>
			<div>
				<div data-role="input">
					<input type="search" name="keyword" placeholder="논문명 / 개요 / 키워드">
				</div>
			</div>
		</li>
		<?php } ?>
	</ul>
</div>

<?php if ($publisher != null) { ?>
<div data-role="publisher">
	<b><?php echo $publisher->title; ?></b>
	
	<ul>
		<li>ISBN : <?php echo $publisher->isbn; ?></li>
		<li>WEBSITE : <a href="<?php echo $publisher->link; ?>" target="_blank"><?php echo $publisher->link; ?></a></li>
	</ul>
</div>
<?php } ?>

<?php if ($author != null) { ?>
<div data-role="author">
	<i class="photo" style="background-image:url(<?php echo $author->photo; ?>);"></i>
	
	<div>
		<b><?php echo $author->nickname; ?></b>
		<ul>
			<li><?php echo $me->getText('step/'.$author->extras->step); ?></li>
			<li>Email : <?php echo $author->email; ?></li>
		</ul>
	</div>
</div>
<?php } ?>

<h4>Total Results : <?php echo number_format($total); ?></h4>

<ul data-role="list" class="paper">
	<?php foreach ($lists as $item) { ?>
	<li>
		<b><?php echo $item->title; ?></b>
		
		<div class="author">
			<i class="xi xi-users"></i>
			<?php foreach ($item->author as $member) { ?>
				<?php if ($member->midx == 0) { ?><span><span><?php echo $member->name; ?></span></span><?php } ?>
				<?php if ($member->midx > 0) { $member = $IM->getModule('member')->getMember($member->midx); ?><span><a href="<?php echo $me->getUrl('list','author/'.$member->idx); ?>"><i class="photo" style="background-image:url(<?php echo $member->photo; ?>);"></i><?php echo $member->nickname; ?></a></span><?php } ?>
			<?php } ?>
		</div>
		
		<div class="publisher">
			<i class="xi xi-book-spread"></i>
			<a href="<?php echo $me->getUrl('list','publisher/'.$item->publisher->idx); ?>"><?php echo $item->publisher->title; ?></a>,
			Volume : <?php echo $item->volume_no; ?><?php if ($item->issue_no > 0) { ?>, Issue : <?php echo $item->issue_no; ?><?php } ?>, PP : <?php echo $item->page_no; ?> (<a href="<?php echo $me->getUrl('list','year/'.$item->year); ?>"><?php echo $item->year; ?></a>)
		</div>
	</li>
	<?php } ?>
</ul>

<div class="pagination"><?php echo $pagination; ?></div>