The system is supposed to move files from high volume directory into respective distinations.
> Active logging.
> House keeping protocols.
> Email Notifications.
> File management.
> Multi-tasking.

@#####Notes on optimisation parse method without overloading memory#####@
- The max memory needed to run a large file depends on the longest line in the input.
- Of course remembering to fclose($handle);



####Pthreads####################################
pthreads is an Object Orientated API that allows user-land multi-threading in PHP.
It includes all the tools you need to create multi-threaded applications targeted at the Web or the Console.
PHP applications can create, read, write, execute and synchronize with Threads, Workers and Stackables.

###################################################################
MAXIMUM EXECUTION TIME
By default, the maximum execution time for PHP scripts is set to 30 seconds.
If a script runs for longer than 30 seconds, PHP stops the script and reports an error.
You can control the amount of time PHP allows scripts to run by changing
the max_execution_time directive in your php.ini file.
Currently changed = 300 seconds to extend execution. 6min

####The above was overriden by passing zero value to extend execution to unlimited time.####

##############################################################################
Simplefileobject class.

Note that this class has a private (and thus, not documented) property that holds the file pointer.
Combine this with the fact that there is no method to close the file handle, and you get into situations
where you are not able to delete the file with unlink(), etc., because an SplFileObject still has a handle open.
####you have to close stream by passing null value to spl object####
