<?php
/**
 * Написать функцию которая из этого массива
 */
$data1 = [
    'parent.child.field' => 1,
    'parent.child.field2' => 2,
    'parent2.child.name' => 'test',
    'parent2.child2.name' => 'test',
    'parent2.child2.position' => 10,
    'parent3.child3.position' => 10,
    'parent4.child.value' => 'сделает такой и наоборот',
];

//сделает такой и наоборот
$data = [
    'parent' => [
        'child' => [
            'field' => 1,
            'field2' => 2,
        ]
    ],
    'parent2' => [
        'child' => [
            'name' => 'test'
        ],
        'child2' => [
            'name' => 'test',
            'position' => 10
        ]
    ],
    'parent3' => [
        'child3' => [
            'position' => 10
        ]
    ],
    'parent4' => [
        'child' => [
            'value' => 'сделает такой и наоборот'
        ]
    ],
];

function decode($data) {
	$result = [];
	foreach($data as $route => $value){
		$points = explode('.', $route);
		$node = &$result;
		while ($points) {
			$key = array_shift($points);
			if (!isset($node[$key])) {
				$node[$key] = null;
			}
			$node = &$node[$key];
		}
		$node = $value;
	}
	return $result;
}

function encode($data) {
	$result = [];
	if(!empty($data) && is_array($data)){
		$raw = str_replace(
			['%5B', '%5D'],
			['.', ''],
			http_build_query($data)
		);
		$vars = explode('&', $raw);
		foreach ($vars as $var) {
			list($key, $value) = explode('=', $var) + [null,null];
			$result[$key] = urldecode($value);
		}
	}
	return $result;
}
print_r(decode($data1));
print_r(encode($data));