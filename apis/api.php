<?php
if (isset($_POST['access'])) {
	error_reporting(0);
	$domain = $_POST['address'];
	if (strlen($_POST['address']) < 2) {
		?>
		<div class="col-sm-8 mx-auto">
                <p class="bd-content-title h2 text-center">TRANG THÁI SERVER </p>
                <p class="text-center">Địa chỉ IP: <?=$domain?> không hợp lệ</p>
            </div>
		<?php 
	} else {
		//get api from mcsrvstat.us - thanks to author api
		$get_api = json_decode(file_get_contents("https://api.mcsrvstat.us/2/$domain"));
		if (!$get_api) {?>
			<div class="row">
			<div class="col-xl-5 mx-auto">
                <p class="bd-content-title h2 text-center">TRANG THÁI SERVER </p>
                <p class="text-center">Lỗi API, vui lòng thử lại !</p>
            </div>
        </div>
		<?php }?>
		<?php 
		if ($get_api->online == false) {
			?>
			<div class="row">
			<div class="col-xl-5 mx-auto">
                <p class="bd-content-title h2 text-center">TRANG THÁI SERVER </p>
                <p class="text-center">Địa chỉ IP: <?=$domain?> đang Offline hoặc không tìm thấy !</p>
            </div>
        </div>
            <?php
		} else {
			$port = $get_api->port;
			$ip = $get_api->ip;
			$motd = $get_api->motd->html[0];
			if (isset($get_api->motd->html[1])) {
			$motd1 = $get_api->motd->html[1];
		} else {
			$motd1 = '';
		}
			$version = $get_api->version;
			if (isset($get_api->icon)) {
			$icon = $get_api->icon;
			$icon_st = true;
		} else {
			$icon = '';
			$icon_st = false;
		}
			$player = $get_api->players->online;
			$player_max = $get_api->players->max;
			$api_ver = $get_api->debug->apiversion;
			if (isset($get_api->mods)) {
			$mod = $get_api->mods->names;
			foreach ($mod as $mods_list) {
				$num = 0;
				$mods_list = $get_api->mods->names[$num++];
			}
		} else {
			$mods_list = 'Không có';
		}
		if ($get_api->debug->srv == true) {
			$srv = 'Có';
		} else {
			$srv = 'Không';
		}
		$cache_time = $get_api->debug->cachetime;
		$protocol = $get_api->protocol;
		$query = $get_api->debug->query;
		if ($query == true) {
			$query = 'Có';
		} else {
			$query = 'Không';
		}
			?>
			<div class="row">
				<p class="h4 text-center"><?php if ($icon_st == true) {?><img src="<?=$icon?>" alt="icon" width="49"><?php } else {?><?php }?> Thông tin máy chủ: <?=$domain?></p>
				 <div class="dropdown-divider"></div>
				 <br>
			<div class="col-xl-6">
                <p class="bd-content-title h2 text-center">THÔNG TIN </p>
                <p class="text-center">Địa chỉ Tên miền: <?=$domain?></p>
                <p class="fw-bold">MOTD:</p>
                <p class="ske-motd"><?=$motd?><br><?=$motd1?></p>
                <p >Người chơi trực tuyến: <span class="fw-bold"><?=$player?>/<?=$player_max?></span></p>
                <p >Phiên bản: <span class="fw-bold"><?=$version?></span></p>
                <p >MOD: <span class="fw-bold"><?=$mods_list?></span></p>
            </div>
            <div class="col-xl-6">
                <p class="bd-content-title h2 text-center">NÂNG CAO </p>
                <p class="text-center">Địa chỉ IP: <?=$ip?></p>
                <p >Cổng: <?=$port?></p>
                <p >Phiên bản API: <span class="fw-bold"><?=$api_ver?></span></p>
                <p >Bản ghi SRV: <span class="fw-bold"><?=$srv?></span></p>
                <p >Thời gian Cache: <span class="fw-bold"><?=$cache_time?></span></p>
                <p >Protocol: <span class="fw-bold"><?=$protocol?></span></p>
                <p >Chế độ Query: <span class="fw-bold"><?=$query?></span></p>
            </div>
        </div>
			<?php
		}
	}
} else {
	die('No per');
}
?>