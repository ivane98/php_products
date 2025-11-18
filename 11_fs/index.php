<?php
// Magic constants


// Create directory

// Rename directory

// Delete directory

// Read files and folders inside directory

// echo file_get_contents('lorem.txt');
// file_get_contents, file_put_contents

// file_put_contents('sample.txt', 'sample');

// file_get_contents from URL

echo json_decode(file_get_contents('https://jsonplaceholder.typicode.com/users'), true);

// https://www.php.net/manual/en/book.filesystem.php
// file_exists
// is_dir
// filemtime
// filesize
// disk_free_space
// file