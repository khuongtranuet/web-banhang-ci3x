<?php
//require_once('barcode-generator/barcode-generator-master/CodeItNow/BarcodeBundle/Utils/QrCode.php');
//use CodeItNow\BarcodeBundle\Utils\QrCode;

if ( ! function_exists('paginate_ajax')) {
	function paginate_ajax($total_record, $page_index = 1, $page_size = 2, $onclick = 'changePage')
	{
		$link = '';
		$index = 1;
		$btn_next = '>';
		$btn_last = '>|';
		$btn_previous = '<';
		$btn_first = '|<';

		if ($total_record > 0 && $page_index >= 1 && $page_size >= 1) {
			$pages = ceil($total_record / $page_size);

			// Previous page
			if ($page_index > 1) {
				$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'(1)">' . $btn_first . '</a>';
				$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.($page_index - 1).')">' . $btn_previous . '</a>';
			}

			if ($pages <= 10) {
				for ($index = 1; $index <= $pages; $index++) {
					if ($index == $page_index) {
						$link .= '<span class="pms-page-current">' . $index . '</span>';
					} else {
						$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$index.')">' . $index . '</a>';
					}
				}
			} else {
				if ($page_index <= 5) {
					for ($index = 1; $index <= 5; $index++) {
						if ($index == $page_index) {
							$link .= '<span class="pms-page-current">' . $index . '</span>';
						} else {
							$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$index.')">' . $index . '</a>';
						}
					}

					$link .= '...';

					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.($pages - 1).')">' . ($pages - 1) . '</a>';
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$pages.')">' . $pages . '</a>';

				} else if ($page_index > 5 && $page_index < ($pages - 4)) {
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'(1)">1</a>';
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'(2)">2</a>';
					$link .= '...';

					for ($index = ($page_index - 2); $index <= ($page_index + 2); $index++) {
						if ($index == $page_index) {
							$link .= '<span class="pms-page-current">' . $index . '</span>';
						} else {
							$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$index.')">' . $index . '</a>';
						}
					}

					$link .= '...';

					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.($pages - 1).')">' . ($pages - 1) . '</a>';
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$pages.')">' . $pages . '</a>';

				} else {
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'(1)">1</a>';
					$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'(2)">2</a>';
					$link .= '...';

					for ($index = ($pages - 4); $index <= $pages; $index++) {
						if ($index == $page_index) {
							$link .= '<span class="pms-page-current">' . $index . '</span>';
						} else {
							$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$index.')">' . $index . '</a>';
						}
					}
				}
			}

			// Next page
			if ($page_index < $pages) {
				$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.($page_index + 1).')">' . $btn_next . '</a>';
				$link .= '<a class="pms-page" href="javascript:void(0)" onclick="'.$onclick.'('.$pages.')">' . $btn_last . '</a>';
			}

		}

		return $link;
	}
}

function echo_pre($data, $die = false)
{
	echo '<pre>';
	print_r($data);
	echo '</pre>';
	if ($die) {
		die();
	}
}

function qrCode($data) {
	$qrCode = new QrCode();
	$start_intend = date("H:m d/m/Y", strtotime($data['start_intend']));
	$end_intend = date("H:m d/m/Y", strtotime($data['end_intend']));
	$text = "Chi tiết: ".$data['name']."\n";
	$text .= "Phòng: ".$data['room_name']."\n";
	$text .= "Thời gian: ".$start_intend." đến ".$end_intend."";
	$qrCode
		->setText($text)
		->setSize(500)
		->setPadding(2)
		->setErrorCorrection('high')
		->setForegroundColor(array('r' => 0, 'g' => 0, 'b' => 0, 'a' => 0))
		->setBackgroundColor(array('r' => 255, 'g' => 255, 'b' => 255, 'a' => 0))
		->setLabel('')
		->setLabelFontSize(16)
		->setImageType(QrCode::IMAGE_TYPE_PNG)
	;
	return '<img id="qrcode" class="qrcode" src="data:'.$qrCode->getContentType().';base64,'.$qrCode->generate().'" width="50" height="50"/>';
}

function getImageFromBase64Encode($str_base64) {
	return 'data:image/png;base64,'.$str_base64;
}

function checkRoles($page = null, $act = null) {
//	echo $page;
//	echo $act;
//	echo_pre($_SESSION['array']);

	if (isset($_SESSION['array'])) {
		$page = isset($page) ? $page : null;
		$act = isset($act) ? $act : null;

		if (isset($page) && $page == 'account') {
			return true;
		}
		if (isset($page) && $page == 'login') {
			return true;
		}
		if (isset($page) && $page != null && isset($act) && $act != null) {
			$check_role = in_array($page, $_SESSION['array']);
			if ($check_role == true) {
				if ($page == 'home') {
					return true;
				}
				$check_permission = in_array($act, $_SESSION['user_roles'][$page]);
//				echo_pre($_SESSION['user_roles'][$page]);
				if ($check_permission == true) {
					return true;
				} else {
					return false;
				}
			} else {
				return false;
			}
		} elseif (isset($page) && $page != null) {
			return in_array($page, $_SESSION['array']);
		}
	}
}

function isEmail($str) {
	if (!filter_var($str, FILTER_VALIDATE_EMAIL)) {
		$emailErr = "Invalid email format";
		return false;
	}else{
		return true;
	}
}

function randomString($length) {
	$chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$size = strlen($chars);
	$str = '';
	for( $i = 0; $i < $length; $i++ ) {
		$str .= $chars[rand(0,$size - 1)];
	}
	return $str;
}

function isFormValidated($errors)
{
	if(count($errors) > 0) {
		return false;
	} else {
		return true;
	}
}
