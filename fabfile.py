from fabric.api import *

import shutil
import tempfile

def build():
    wkdir = tempfile.mkdtemp()
    print('working directory: ' + wkdir)

    zipfile = 'colormeshop-wp-plugin.zip'

    with lcd(wkdir):
        local('git clone git@github.com:pepabo/colormeshop-wp-plugin.git .')
        local('curl -sS https://getcomposer.org/installer | php')
        local('php composer.phar install --no-dev')
        local('zip -r ' + zipfile + " . -x '.git/*' -x '.gitignore' -x '.idea/*' -x 'bin/*' -x Dockerfile -x docker-compose.yml -x phpunit.xml -x 'tests/*' -x wp.env -x wp.env.sample -x composer.phar")

    local('cp ' + wkdir + '/' + zipfile + ' .')

    print('cleaning up the working directory')
    shutil.rmtree(wkdir)
