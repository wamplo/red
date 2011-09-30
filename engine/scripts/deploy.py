#!/usr/bin/env python

# DEVELOPMENT PATH
PATH_APPS = '../../apps/*/'
PATH_ASSETS = PATH_APPS + 'assets'
PATH_VIEWS = PATH_APPS + 'views/*/'

# PRODUCTION PATH
PATH_PRODUCTION = '../../www-static/'

googleclosure = 'bin/googleclosure/googlecc-06.152.011.jar'
yuicompressor = 'bin/yuicompressor/yuicompressor-2.4.6.jar'
optipng = 'bin/imageoptimizer/optipng-0.6.5.exe'
jpegtrans = 'bin/imageoptimizer/jpegtran-8c.exe'
muncher = 'bin/muncher/munch'
gitftp = 'bin/gitftp/git-ftp.py'

# CONFIGURATION
cache = 'cache'
debug = 0
color = 1


# HUMANIZE
Athena = [
"Kissing with ",
"Great! im doing fine with ",
"Hmm, quite funny heh? this ",
"Locating the required gigapixels to render ",
"Spinning up the hamster first... :d ok ",
"My other load screen is much faster. You should try that one instead. ",
"it's still faster than you could draw ",
"why don't you order a sandwich? ",
"don't think of me :) ",
"testing your patience with ",
"would you like fries with that ",
"we're building the buildings as fast as we can with ",
"thinking... maybe he knows -> "
]

# LOAD
try:
	import clint
	import glob
	import os
	import fnmatch
	import sys
	import time
	from random import randint
	from clint.textui import colored
	# IGNORE CSS
	from ignorecss import *

	''' kedepannya kaya gini
	configs = []
	for x in glob.glob(PATH_APPS + '__build__.py'):
		configs.append(x)
	'''

except Exception as inst: # raise e
	print 'Athena: run ./deploy.py setup'
	print 'Error: ' + inst

# SETUP
def setup():
	# https://github.com/kennethreitz/clint
	os.system('easy_install clint');
	os.system('easy_install gitpython');

# UTILITY
def dump(obj):
  for attr in dir(obj):
    print "obj.%s = %s" % (attr, getattr(obj, attr))


# CLEAR CACHE FOLDER
def clearcache2(file):

	if color == 0:
		print 'cleaning up cache...  ' + file

	if color == 1:
		clint.textui.puts('cleaning up cache...  ' + colored.yellow(file))
	
	os.unlink(file)

def clearcache():
	
	import shutil
	folders = os.listdir(PATH_PRODUCTION)
	
	if color == 0:
		print 'Athena: Cleaning up www-static...'

	if color == 1:
		clint.textui.puts(colored.cyan('Athena: Cleaning up www-static...'))
	
	for x in folders:

		# HUMINIZE START
		if color == 0:
			print 'Cleaning up... ' + x

		if color == 1:
			clint.textui.puts('Cleaning up... ' + colored.yellow(x))
		# HUMANIZE END

		if os.path.isdir(PATH_PRODUCTION + x) == True:
			shutil.rmtree(PATH_PRODUCTION + x)
		
		else:
			os.unlink(PATH_PRODUCTION + x)


# IMAGE @todo warning cuma di windows.exe
# PNG todo "*.png" -o -name "*.bmp" -o -name "*.pnm" -o -name "*.tiff"
def images():

	if color == 0:
		print 'Athena: Rendering Images'

	if color == 1:
		clint.textui.puts(colored.cyan('Athena: Rendering Images'))

	# START GET FILES	
	png = []
	for x in glob.glob(PATH_ASSETS + '/img/*.png'):
		png.append(x)

	for x in glob.glob(PATH_ASSETS + '/img/*/*.png'):
		png.append(x)
	# END GET FILES

	for x in png:

		# GET FILE NAME START
		import re
		segment = re.split('/assets/img/', x)
		fullpath = segment[-1]
		folder = fullpath.split('/')
		appseg = re.split('/apps/', segment[0])

		PRODUCTION_ASSETS_FOLDER = PATH_PRODUCTION + appseg[-1] + os.sep + 'assets' + os.sep + 'img' + os.sep;
		PRODUCTION_FULL_PATH = PRODUCTION_ASSETS_FOLDER + '/'.join(folder[0:-1]);
		# GET FILE NAME END

		if debug == 1:
			opt = ' -v'
		if debug == 0:
			opt = ' -quiet'

		# HUMINIZE START
		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + fullpath

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(fullpath))
		# HUMANIZE END

		# START RENDER
		if not os.path.exists(PRODUCTION_FULL_PATH):
			os.makedirs(PRODUCTION_FULL_PATH)

		# START RENDER
		os.system( optipng + opt + ' ' + x + ' -out ' + PRODUCTION_ASSETS_FOLDER + fullpath)

	print '\n'	

	# JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG JPEG

	# START GET FILES	
	jpg = []
	for x in glob.glob(PATH_ASSETS + '/img/*.jpg'):
		jpg.append(x)

	for x in glob.glob(PATH_ASSETS + '/img/*/*.jpg'):
		jpg.append(x)
	# END GET FILES

	for x in jpg:

		# GET FILE NAME START
		import re
		segment = re.split('/assets/img/', x)
		fullpath = segment[-1]
		folder = fullpath.split('/')
		appseg = re.split('/apps/', segment[0])

		PRODUCTION_ASSETS_FOLDER = PATH_PRODUCTION + appseg[-1] + os.sep + 'assets' + os.sep + 'img' + os.sep;
		PRODUCTION_FULL_PATH = PRODUCTION_ASSETS_FOLDER + '/'.join(folder[0:-1]);
		# GET FILE NAME END

		if debug == 1:
			opt = ' -verbose -optimize'
		if debug == 0:
			opt = ' -optimize'

		# HUMINIZE START
		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + fullpath

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(fullpath))
		# HUMANIZE END

		# START RENDER
		if not os.path.exists(PRODUCTION_FULL_PATH):
			os.makedirs(PRODUCTION_FULL_PATH)

		os.system( jpegtrans + opt + ' ' + x + ' ' + PRODUCTION_ASSETS_FOLDER + fullpath)

	print '\n'

# FONTS . ttf
def fonts():

	import shutil

	# HUMANIZE START
	if color == 0:
		print 'Athena: Rendering FONTS'

	if color == 1:
		clint.textui.puts(colored.cyan('Athena: Rendering Javascripts'))
	# HUMANIZE END

	for x in glob.glob(PATH_ASSETS + '/font/*.ttf'):

		# Get file names
		segment1 = x.split('/')
		filename = segment1[-1]
		realname = filename.split('.jpg')
		appfolder = segment1[-4]
		folder = segment1[-2]

		# HUMANIZE START
		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + filename

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(filename))
		# HUMANIZE END 

		PRODUCTION_ASSETS_FOLDER = PATH_PRODUCTION + appfolder + os.sep + 'assets' + os.sep + 'font'
		PRODUCTION_FULL_PATH = PRODUCTION_ASSETS_FOLDER + os.sep + filename

		# START RENDER
		if not os.path.exists(PRODUCTION_ASSETS_FOLDER):
			os.makedirs(PRODUCTION_ASSETS_FOLDER)

		shutil.copy2(x, PRODUCTION_FULL_PATH);
	
	print '\n'	

# JOBS
def javascript():
	
	if color == 0:
		print 'Athena: Rendering Javascripts'

	if color == 1:
		clint.textui.puts(colored.cyan('Athena: Rendering Javascripts'))

	js = []

	for x in glob.glob(PATH_ASSETS + '/js/*.js'):
		js.append(x)

	for x in glob.glob(PATH_ASSETS + '/js/*/*.js'):
		js.append(x)

	#print development + '/js';
	for x in js:

		# Get file names
		import re
		segment = re.split('/assets/js/', x)
		fullpath = segment[-1]
		folder = fullpath.split('/')
		appseg = re.split('/apps/', segment[0])
			
		PRODUCTION_ASSETS_FOLDER = PATH_PRODUCTION + appseg[-1] + os.sep + 'assets' + os.sep + 'js' + os.sep;
		PRODUCTION_FULL_PATH = PRODUCTION_ASSETS_FOLDER + '/'.join(folder[0:-1]);

		if not os.path.exists(PRODUCTION_FULL_PATH):
			os.makedirs(PRODUCTION_FULL_PATH)

		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + fullpath

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(fullpath))

		if debug == 1:
			opt = ' --warning_level VERBOSE --debug  --js'
		if debug == 0:
			opt = ' --warning_level QUIET --summary_detail_level 0  --js'

		os.system('java -jar ' + googleclosure + opt + ' '+ x +' --js_output_file ' + PRODUCTION_ASSETS_FOLDER + fullpath)

	print '\n'

def deploy():
	os.system(gitftp)

def views():

	import shutil

	# RENDER
	css = [];
	for x in glob.glob(PATH_ASSETS + '/css/*.css'):
		css.append(x)

	views = [];
	for x in glob.glob(PATH_VIEWS + '*.php'):
		views.append(x)
	
	# HARUS STR 
	print ','.join(IGNORECSS);
	os.system(muncher + ' --css ' + ','.join(css) + ' --views ' + ','.join(views) + ' --ignore ' + ','.join(IGNORECSS))
	
	# VIEWS
	for x in glob.glob(PATH_VIEWS + '*.opt.php'):

		# Get file names
		segment1 = x.split('/')
		filename = segment1[-1]
		realname = filename.split('.opt.php')
		appfolder = segment1[-4]
		folder = segment1[-2]

		PRODUCTION_VIEWS_FOLDER = PATH_PRODUCTION + appfolder + os.sep + 'views' + os.sep + folder ;
		PRODUCTION_VIEWS = PRODUCTION_VIEWS_FOLDER + os.sep + realname[0] + '.php';

		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + realname

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(realname[0] + '.php'))

		if not os.path.exists(PRODUCTION_VIEWS_FOLDER):
		    os.makedirs(PRODUCTION_VIEWS_FOLDER)

		shutil.move(x, PRODUCTION_VIEWS)

	# CSS
	for x in glob.glob(PATH_ASSETS + '/css/*.opt.css'):

		# Get file names
		segment1 = x.split('/')
		filename = segment1[-1]
		realname = filename.split('.opt.css')
		folder = segment1[-4]

		PRODUCTION_ASSETS_FOLDER = PATH_PRODUCTION + folder + os.sep +  'assets' + os.sep + 'css';
		PRODUCTION_ASSETS_CSS = PRODUCTION_ASSETS_FOLDER + os.sep + realname[0] + '.css';

		if not os.path.exists(PRODUCTION_ASSETS_FOLDER):
		    os.makedirs(PRODUCTION_ASSETS_FOLDER)

		if color == 0:
			print Athena[randint(0,len(Athena)-1)] + filename

		if color == 1:
			clint.textui.puts(Athena[randint(0,len(Athena)-1)] + colored.yellow(filename))

		if debug == 1:
			opt = '-v --type=css'

		if debug == 0:
			opt = '--type=css'	

		os.system('java -jar '+ yuicompressor + ' ' + opt + ' ' + x +' -o ' + x)
		shutil.move(x, PRODUCTION_ASSETS_CSS)
	
	print '\n'	

def generatereadme():

	# GENERATE
	localtime = time.asctime( time.localtime(time.time()) )

	# Open a file
	fo = open(PATH_PRODUCTION + "README.markdown", "wb")
	fo.write( "# Athena : BUILD " + localtime + "\n working great! \n");
	# Close opend file
	fo.close()

def updateandupload():
	clearcache()
	views() # css, and views
	images()
	javascript()
	fonts()
	generatereadme()
	os.system('git addremove');
	os.system('git commit -m "Anthena: Auto build on ' + time.asctime( time.localtime(time.time())) + '"')
	deploy()
	os.system('git push');

def updatelocal():
	views() # css, and views

# IF FROM COMMAND LINE
if __name__ == '__main__':
	
	try:
		
		if color == 0:
			print 'RED (Athena) 0.1\n'

		if color == 1:
			clint.textui.puts(colored.red('RED') + ' (Athena) 0.1\n')
		
		#setup
		#checksystem()

		if len(sys.argv) == 1:
			print 'Hello, what would you like ?\n'
			print '    all, build everthing'
			print '    deploy, deploy netcoid!'
			print '    setup, first run install deploy'

		if len(sys.argv) == 2:
			if sys.argv[1] == 'all':
				views() # css, and views
				images()
				javascript()
				fonts()
				generatereadme()

			if sys.argv[1] == 'deploy':
				deploy()

			if sys.argv[1] == 'setup':
				setup()

			if sys.argv[1] == 'flush':
				clearcache()

			if sys.argv[1] == 'update':
				updatelocal()

			if sys.argv[1] == 'test':
				print 'helloworld'
				updateandupload()


	except Exception as inst:
		print 'Athena: ouch theres something in the way!'
		print inst

else:
	print 'im imported'

# @todo BAHAYA KARENA PAKE OS harus diubah ke subprocess tp masih ada error fork terus