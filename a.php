<th id="salesDate">発売日<button type="submit" id="sort" name="asc" value="salesDate">▲</button><button type="submit" id="sort" name="desc" value="salesDate">▼</button></th>
<th id="itemPrice">金額<button type="submit" id="sort" name="asc" value="price">▲</button><button type="submit" id="sort" name="desc" value="price">▼</button></th>
<th id="stock">在庫数<button type="submit" id="sort" name="asc" value="stock">▲</button><button type="submit" id="sort" name="desc" value="stock">▼</button></th>

function Asc($books,$column){
	foreach ((array) $books as $key => $value) {
		$sort[$key] = $value[$column];
	}
	array_multisort($sort, SORT_ASC, $books);
	return $books;
}

function Desc($books,$column){
	foreach ((array) $books as $key => $value) {
		$sort[$key] = $value[$column];
	}
	array_multisort($sort, SORT_DESC, $books);
	return $books;
}

//昇順、降順ボタンを押した場合
if(isset($_POST['asc'])){
	$column = $_POST['asc'];
	$books = Asc($books,$column);
}
else if(isset($_POST['desc'])){
	$column = $_POST['desc'];
	$books = Desc($books,$column);
}
