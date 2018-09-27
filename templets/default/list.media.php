<?php
/**
 * 이 파일은 iModule 출판물관리모듈의 일부입니다. (https://www.imodules.io)
 *
 * 출판물관리모듈 기본템플릿 (목록보기)
 * 
 * @file /modules/publication/templets/default/list.media.php
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
			<li<?php echo $mode == 'publisher' ? ' class="selected"' : ''; ?>><a href="<?php echo $me->getUrl('list','publisher'); ?>">언론매체별</a></li>
			<li<?php echo $mode == 'author' ? ' class="selected"' : ''; ?>><a href="<?php echo $me->getUrl('list','author'); ?>">대상</a></li>
		</ul>
	</div>
</div>

<div class="searchbox">
	<ul>
		<li class="input">
			<ul>
				<?php if ($mode == 'year') { ?>
				<li>
					<label>연도</label>
					<div>
						<div data-role="input">
							<select name="code">
								<?php foreach ($selectors as $selector) { ?>
								<option value="<?php echo $selector->year; ?>"<?php echo $code == $selector->year ? ' selected="selected"' : ''; ?>><?php echo $selector->year.'년도 ('.number_format($selector->count).'건)'; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</li>
				<?php } ?>
				
				<?php if ($mode == 'publisher') { ?>
				<li>
					<label>언론매체명</label>
					<div>
						<div data-role="input" data-search="<?php echo $IM->getProcessUrl('publication','searchPublisher'); ?>?type=<?php echo $type; ?>">
							<input type="search" name="publisher" placeholder="등록되어 있는 저널명이 자동검색됩니다." autocomplete="off" value="<?php echo $publisher != null ? $publisher->title : ''; ?>">
						</div>
					</div>
				</li>
				<?php } ?>
				
				<?php if ($mode == 'author') { ?>
				<li>
					<label>저자</label>
					<div>
						<div data-role="input">
							<select name="code">
								<?php foreach ($selectors as $selector) { ?>
								<option value="<?php echo $selector->idx; ?>"<?php echo $code == $selector->idx ? ' selected="selected"' : ''; ?>><?php echo $me->getAuthorName($IM->getModule('member')->getMember($selector->idx)).' ('.number_format($selector->count).'건)'; ?></option>
								<?php } ?>
							</select>
						</div>
					</div>
				</li>
				<?php } ?>
				
				<li>
					<label>검색어</label>
					<div>
						<div data-role="input">
							<input type="search" name="keyword" placeholder="기사명" value="<?php echo GetString($keyword,'input'); ?>">
						</div>
					</div>
				</li>
			</ul>
		</li>
		<li class="button">
			<button type="submit">검색하기</button>
		</li>
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
		<b><?php echo $me->getAuthorName($author); ?></b>
		<ul>
			<li><?php echo $me->getText('step/'.$author->extras->step); ?></li>
			<li>Email : <?php echo $author->email; ?></li>
		</ul>
	</div>
</div>
<?php } ?>

<h4>Total Results : <?php echo number_format($total); ?></h4>

<ul data-role="list">
	<?php foreach ($lists as $item) { ?>
	<li>
		<small><?php echo $item->loopnum; ?>.</small>
		<b><?php echo $item->title; ?><?php echo $item->link ? '<a href="'.$item->link.'" target="_blank"><i class="xi xi-external-link"></i></a>' : ''; ?><?php echo $item->file != null ? '<a href="'.$item->file->download.'" download="'.$item->file->name.'"><i class="icon" style="background-image:url('.$item->file->icon.');">'.$item->file->name.'</i></a>' : ''; ?></b>
		
		<?php if (count($item->author) > 0) { ?>
		<div class="author">
			<i class="xi xi-users"></i>
			<?php foreach ($item->author as $member) { ?>
				<?php if ($member->midx == 0) { ?><span><span><?php echo $member->name; ?></span></span><?php } ?>
				<?php if ($member->midx > 0) { $member = $IM->getModule('member')->getMember($member->midx); ?><span><a href="<?php echo $me->getUrl('list','author/'.$member->idx); ?>"><?php echo $me->getModule()->getConfig('author_photo') == true ? '<i class="photo" style="background-image:url('.$member->photo.');"></i>' : ''; ?><?php echo $me->getAuthorName($member); ?></a></span><?php } ?>
			<?php } ?>
		</div>
		<?php } ?>
		
		<div class="publisher">
			<i class="xi xi-book-spread"></i>
			<a href="<?php echo $me->getUrl('list','publisher/'.$item->publisher->idx); ?>"><?php echo $item->publisher->title; ?></a>,
			<?php echo date('F d, Y',strtotime($item->page_no)); ?> (<a href="<?php echo $me->getUrl('list','year/'.$item->year); ?>"><?php echo $item->year; ?></a>)
		</div>
	</li>
	<?php } ?>
</ul>

<div class="pagination"><?php echo $pagination; ?></div>