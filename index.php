<?php include_once('header.php'); ?>
<?php
if(isset($_GET['Added_Posts'])){
	echo $_GET['Added_Posts'].' постів добавлено';
}
if(isset($_GET['group_id_for_posting'])){
    $group_id_for_posting = $_GET['group_id_for_posting'];
}
else{
    $group_id_for_posting = "";
}

if(isset($_GET['group_id_for_get_post'])){
    $group_id_for_get_post = $_GET['group_id_for_get_post'];
}
else{
    $group_id_for_get_post = "";
}

if(isset($_GET['count'])){
    $count = $_GET['count'];
}
else{
    $count = "";
}

if(isset($_GET['offset'])){
    $offset = $_GET['offset'];
}
else{
    $offset = "";
}



if(isset($_GET['photos_in_post'])){
    $photos_in_post = $_GET['photos_in_post'];
}
else{
    $photos_in_post = "";
}


if(isset($_GET['comments'])){
    $comments = $_GET['comments'];
}
else{
    $comments = "";
}


if(isset($_GET['likes'])){
    $likes = $_GET['likes'];
}
else{
    $likes = "";
}


if(isset($_GET['views'])){
    $views = $_GET['views'];
}
else{
    $views = "";
}


if(isset($_GET['reposts'])){
    $reposts = $_GET['reposts'];
}
else {
    $reposts = "";
}

if(isset($_GET['start_time_for_post'])){
    $start_time_for_post = $_GET['start_time_for_post'];
}
else {
    $start_time_for_post = "";
}

if(isset($_GET['count_text'])){
    $count_text = $_GET['count_text'];
}
else {
    $count_text = "";
}

if(isset($_GET['period_posts'])){
    $period_posts = $_GET['period_posts'];
}
else {
    $period_posts = "";
}
?>
<div class="add-posts">
<form action="/post-to-vk.php" method="get">
	<label for="group_id_for_posting">Ід групи для постінга</label>
	<input type="text" name="group_id_for_posting" required value="<?php echo $group_id_for_posting?>">

	<label for="group_id_for_get_post">Ід групи де брати пости</label>
	<input type="text" name="group_id_for_get_post"  value="<?php echo $group_id_for_get_post?>" required>

	<label for="count">Кількість постів</label>
	<input type="text" name="count" required  value="<?php echo $count?>">

	<label for="offset">Кількість пропусків постів</label>
	<input type="text" name="offset" value="<?php echo $offset?>" required >

	<label for="photos_in_post">Мінімальна кількість фото в пості</label>
	<input type="text" name="photos_in_post"  value="<?php echo $photos_in_post?>" required>

	<label for="comments">Мінімальна кількість коментарів</label>
	<input type="text" name="comments"  value="<?php echo $comments?>" required>

	<label for="likes">Мінімальна кількість лайків в пості</label>
	<input type="text" name="likes"  value="<?php echo $likes?>" required>

	<label for="reposts">Мінімальна кількість репостів в пості</label>
	<input type="text" name="reposts"  value="<?php echo $reposts?>" required>

	<label for="views">Мінімальна кількість охвата поста</label>
	<input type="text" name="views"  value="<?php echo $views?>" required>

	<label for="cout_text">Мінімальна кількість символів в тексті</label>
	<input type="text" name="cout_text"  value="<?php echo $count_text?>" required>


	<label for="start_time_for_post">Дата від якої починати кидати в відложку Рік-місяць-день година:хвилина</label>
	<input type="text" name="start_time_for_post" required  value="<?php echo $start_time_for_post?>">

	<label for="period_posts">Періодичність постів в (хв)</label>
	<input type="text" name="period_posts" required  value="<?php echo $period_posts?>">

	<button type="submit">Добавити пости</button>
</form>
</div>
<?php include_once('footer.php'); ?>



