from fabric.api import *

import os
import shutil
import tempfile

def build(mode='release'):
    currentdir = os.path.dirname(__file__)
    wkdir = tempfile.mkdtemp()
    print('working directory: ' + wkdir)

    zipfile = 'colormeshop-wp-plugin.zip'

    with lcd(wkdir):
        excludes = [
                '".git/*"',
                '".gitignore"',
                '".idea/*"',
                '"bin/*"',
                'Dockerfile',
                'docker-compose.yml',
                'phpunit.xml',
                '"tests/*"',
                'wp.env',
                'wp.env.sample',
                'composer.phar',
                'fabfile.py',
                'README.md',
                'Pipfile',
                'Pipfile.lock',
                ]
        if mode == 'dev':
            local('cp -r ' + currentdir + '/* ./')
        elif mode == 'release':
            local('git clone git@github.com:pepabo/colormeshop-wp-plugin.git .')
        else:
            abort('invalid argument : ' + mode)
        local('curl -sS https://getcomposer.org/installer | php')
        local('php composer.phar install --no-dev')
        local('zip -r ' + zipfile + ' . -x ' + (' -x '.join(excludes)))

    local('cp ' + wkdir + '/' + zipfile + ' .')

    print('cleaning up the working directory')
    shutil.rmtree(wkdir)

def generate_api_client():
    wkdir = tempfile.mkdtemp(dir=os.path.dirname(__file__))
    print('working directory: ' + wkdir)
    with lcd(wkdir):
        local('docker run --rm -v ${PWD}:/local swaggerapi/swagger-codegen-cli:v2.3.0 generate -i https://api.shop-pro.jp/v1/swagger.json -l php --invoker-package "ColorMeShop\Swagger" -o /local')

    local('cp -R ' + wkdir + '/SwaggerClient-php/lib/ src/Swagger/')
    local('rm -rf ' + wkdir)
