<footer class=" text-sm">
<!-- <footer class=" text-sm" style="position: fixed;right: 0;bottom: 0;left: 0;z-index: 9999;"> -->
	<nav class="navbar navbar-light bg-light border-top navbar-expand d-md-none d-lg-none d-xl-none fixed-bottom" style="z-index: 9999;">
		<ul class="navbar-nav nav-justified w-100">
			<?php
			$data = '';
			if (count($menu) > 1) {
				foreach ($menu as $list) {
						$data .='<li class="nav-item"><a href="'.$base_url.$list->url.'" class="nav-link">
						<i class="'.$list->icon.' text-primary icon-xl"></i>
						<span class="small d-block text-primary">'.$list->menu_desc.'</span>
					</a></li>';
				}
			}
			echo $data;?>

			<!-- <li class="nav-item">
				<a href="<?= base_url() ?>" class="nav-link">
					<i class="fas fa-home text-primary icon-xl"></i>
					<span class="small d-block text-primary">Home</span>
				</a>
			</li>
			
			<li class="nav-item">
				<a href="<?= base_url('order') ?>" class="nav-link">
					<i class="fas fa-shopping-basket text-primary icon-xl"></i>
					<span class="small d-block text-primary">Order</span>
				</a>
			</li>
			<li class="nav-item">
				<a href="<?= base_url('stock_barang') ?>" class="nav-link">
					<i class="fas fa-boxes text-primary icon-xl"></i>
					<span class="small d-block text-primary">Stock</span>
				</a>
			</li>
			
			<li class="nav-item">
				<a href="<?= base_url('transaksi') ?>" class="nav-link">
					<i class="fas fa-clipboard-list text-primary icon-xl"></i>
					<span class="small d-block text-primary">Transaksi</span>
				</a>
			</li>

			<li class="nav-item">
				<a href="<?= base_url('ekspedisi') ?>" class="nav-link">
					<i class="fas fa-shipping-fast text-primary icon-xl"></i>
					<span class="small d-block text-primary">Ekspedisi</span>
				</a>
			</li> -->
			
		</ul>
	</nav>
</footer>
