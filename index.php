<?php include_once('header.php'); ?>
<div class="add-posts">
<form action="/post-to-vk.php" method="get">
	<label for="group_id_for_posting">Ід групи для постінга</label>
	<input type="text" name="group_id_for_posting" required>

	<label for="group_id_for_get_post">Ід групи де брати пости</label>
	<input type="text" name="group_id_for_get_post" required>

	<label for="count">Кількість постів</label>
	<input type="text" name="count" value="24" required>

	<label for="offset">Кількість пропусків постів</label>
	<input type="text" name="offset" value="24" required>

	<label for="photos_in_post">Мінімальна кількість фото в пості</label>
	<input type="text" name="photos_in_post" value="1" required>

	<label for="comments">Мінімальна кількість коментарів</label>
	<input type="text" name="comments" value="3" required>

	<label for="likes">Мінімальна кількість лайків в пості</label>
	<input type="text" name="likes" value="30" required>

	<label for="reposts">Мінімальна кількість репостів в пості</label>
	<input type="text" name="reposts" value="10" required>

	<label for="views">Мінімальна кількість охвата поста</label>
	<input type="text" name="views" value="1000" required>

	<label for="cout_text">Мінімальна кількість символів в тексті</label>
	<input type="text" name="cout_text" value="5" required>


	<label for="start_time_for_post">Дата від якої починати кидати в відложку Рік-місяць-день година:хвилина</label>
	<input type="text" name="start_time_for_post" required>

	<label for="period_posts">Періодичність постів в (хв)</label>
	<input type="text" name="period_posts" value="<?php echo new DateTime('now', 'Europe/Kiev')?>" required>

	<button type="submit">Добавити пости</button>
</form>
</div>
<?php include_once('footer.php'); ?>



