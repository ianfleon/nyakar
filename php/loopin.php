<?php

/* LOG!
* ERROR : Tidak bisa pakai {{}}
* ERROR : Tidak bisa pakai HTML Commentar
*/

$data = file_get_contents('loop.html');
$GLOBALS['data'] = $data;


$regs = [];
preg_match_all('/\{{(.*?)}}/', $data, $regs);

$commands = explode(' ', trim($regs[1][0]));

// # Check is function
if ($commands[0][0] == '#') {
	FUNC_LOOPIN($commands);
}

function FUNC_LOOPIN($commands)
{

	// # Hapus kw. #loopin
	unset($commands[0]);

	// # Mengambil data setelah #loopin
	$commands = implode(' ', $commands);
	$commands = explode(':', $commands);

	// echo $commands[1];
	// var_dump($commands);

	// # Sample Data
	$Posts = [
		['judul' => 'Naruto',
		'deskripsi' => 'Anak bocil dari konoha'],
		['judul' => 'Hunter X Hunter',
		'deskripsi' => 'Bocil kematian'],
		['judul' => 'One Piece',
		'deskripsi' => 'Bajak laut']
	];

	$string_text = '{{ #loopin }} This is some text. This is some text, etc... {{ #endloopin }}';


	// # Menampung data yang didapat regex
	$match = [];

	// # Data setelah looping
	$resultLoopin = '';

	// # Mengambil string diantara #loop #endloop
	preg_match("/\{{.*#loopin.*\}}(.+){{.*#endloopin.*\}}/is" , $GLOBALS['data'], $match);

	// # Cek count looping
	if ($commands[1] < 1) {
		return false;
	}

	// # Looping dan assign data
	foreach ($Posts as $i => $value) {

		// # Jika sama dengan batas yang diberikan
		if ($i == intval($commands[1])) {
			break;
		}

		// var_dump($match[1]);

		// # Assign ke variabel
		$resultLoopin .= trim($match[1]);
	}

	// echo $resultLoopin;
	
	// # Replace dan Assign data baru dan menghapus blok {{}}
	$res = preg_replace("/\{{.*#loopin.*\}}|{{.*#endloopin.*\}}/is" , $resultLoopin, $GLOBALS['data']);

	echo $res;

	// echo trim($match[1]);
	// var_dump($rx_loop);
	// var_dump($match);
}