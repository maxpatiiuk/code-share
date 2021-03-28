# SOCKSY SHOP

* history
* multiple sizes, colors, count
* add to cart
* show similar
* comments - just 5 starts

* search? filtering?
* sorting by (default - our) / popularity (views) / price asc / price desc
* show out of stock items or make them unlisted? 
* image compression by tiny

* register
* checkout
* checkout no account
* payment
* delivery

SQL:
	s_posts:
		content > description
		tinymce > cut it out
		parameters +=
			size:color:max_available
			images > text (json: [url, del_url, is_esc])
			video > esc ?
			comments: no feedback _ or facebook comments
		src > text (automatic out of images)
		price
		views
		visibility: 
			0 - hidden
			1 - visible
			2 - archived (unlisted)
			also, show as out of stock if is out of stock

	s_users:
		viewing_histroy
		leave_feedback after the purchase

	s_orders:
		id > int 5
		time > int 10
		fullfilled > bool
		products > text (json: [id,color,count,description,cost])
		delivery
	s_categories:
		show only posts that have 1