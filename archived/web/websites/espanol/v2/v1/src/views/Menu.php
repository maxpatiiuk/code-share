<div id="zoomable" style="display:none !important;"><img src="" alt="zoomable image"></div>

<div id="menu">

	<a href="<?= Site::$link ?>" id="logo"></a>

	<nav class="navbar navbar-expand-sm navbar-light">
		<div class="mx-auto d-sm-flex d-block flex-sm-nowrap">
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbar">
				<ul class="navbar-nav text-xs-only-center">
				</ul>
			</div>
		</div>
	</nav>

</div><?php

if(Data::formatData('container') === true)
	echo '<div class="container">';