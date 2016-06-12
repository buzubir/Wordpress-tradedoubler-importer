<?php
$xml = simplexml_load_file('TRADE DOUBLER XML GOES HERE');
$products = $xml->product;
foreach ($products as $key => $product) { 
	$productName = $product->name;
	$productURL = $product->productUrl;
	$productIMG = $product->imageUrl;
	$productPrice = $product->price;
	$currency = $product->currency;
	$productDESC = $product->description;
	$TDCategoryName = $product->TDCategoryName;
	$productCAT = $product->merchantCategoryName;

	$parentcatterm = term_exists($TDCategoryName, 'category');
	$catTerm = term_exists($productCAT, 'category');
	if(!$parentcatterm){
		wp_insert_term($TDCategoryName, 'category');	
	}
	$parentCatID = get_cat_ID($TDCategoryName);
	if(!$catTerm){
			wp_insert_term(
				$productCAT,
				'category',
				array(
					'parent' => $parentCatID
					));
	}

	$CATID = get_cat_ID($productCAT);
	$postCont = "<img src='".$productIMG."'>"."<br>".$productDESC;
	$post = array(
		'post_content'   => $postCont, // The full text of the post.
		'post_title'     => $productName, // The title of your post.
		'post_status'    => 'draft',
		'post_type'      => 'post',
		'post_category'  => array($CATID));
	
	wp_insert_post($post);
}
?>