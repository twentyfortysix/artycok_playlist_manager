#!/usr/bin/env perl
# Function	: dir
# Arguments	: The path of the directory whose directory list you want
# Returns	: A flat list with the path of all the files in the directory given as the argument.
# This function will take a folder as the argument and go thru every it recursively and return the list of 
#		all files and folders in that folder.
#		
open (MYFILE, '>>data.txt');


sub dir {
	my $current_folder = shift;
	my @all;
	
	chdir($current_folder) or die("Cannot access folder $current_folder");

	#Get the all files and folders in the given directory.
	my @both = glob("*");

	my @folders;
	foreach my $item (@both) {
		if(-d $item) { #Get all folders into another array - so that first the files will appear and then the folders.
			push(@folders,$item);
		} else { #If it is a file just put it into the final array.
			push(@all,$item);
		}
	}

	foreach my $this_folder (@folders) {
		#Add the directory name to the return list - comment the next line if you don't want this feature.
		push(@all,"$this_folder/");

		#Continue calling this function for all the folders
		my $full_path = "$current_folder/$this_folder";

		my @deep_items = dir($full_path); # :RECURSION:
		foreach my $item (@deep_items) {
			push(@all,"$this_folder/$item");
		}
	}
	return @all;
}
my @all  = dir(".");
foreach my $item (@all) { 
	print MYFILE "$item\n";
	# print "$item\n";
}

close (MYFILE); 
