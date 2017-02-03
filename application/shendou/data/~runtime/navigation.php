<div class="warp">
	<div class="container">

		<nav class="navbar navbar-default">
			<div class="navbar-header">
				<button class="navbar-toggle" type="button" data-toggle="collapse" data-target=".navbar-collapse">
					<span class="sr-only">Toggle navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/"><img src="/themes/images/logo.png" style="height: 34px;margin-top: -6px;"/></a>
			</div>
		
			<div class="collapse navbar-collapse">
				<ul class="nav navbar-nav">
					<li><a href="/">Home</a></li>
					<?php echo $this->showWebMenu(0);;?>	
				</ul>
				<div class="search-box">
					<form name="formsearch" action="/index.php?s=index/search" method="post">
						<input name="k" type="text" placeholder="search" id="search-keyword"> 
						<span class="glyphicon glyphicon-search" id="search-btn">		
							<input value="search" type="submit" style="display: none;">
						</span>
					 </form>
				</div>
				<div class="lang">
					<a>EN</a> | <a>FR</a>
				</div>
			</div>
		</nav>

	</div> <!-- /container -->
</div>