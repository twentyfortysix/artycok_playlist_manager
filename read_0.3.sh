#!/usr/bin/env perl
$dir= shift || '.';

opendir DIR, $dir or die "Can't open directory $dir: $!\n";

@files=readdir(DIR);

print "@files";