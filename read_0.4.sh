#!/usr/bin/perl
my @files = map { chomp; $_ } `find`;
print @files;