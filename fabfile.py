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

swagger_codegen_dir = '~/src/github.com/swagger-api/swagger-codegen/'

def setup_swagger_codegen():
    print('download swagger-codegen')
    local('ghq get git@github.com:swagger-api/swagger-codegen.git')
    with lcd(swagger_codegen_dir):
        with settings(warn_only=True):
            print('checkout v2.3.0')
            result = local('git checkout -b 2.3.0 origin/2.3.0', capture=True)
        if result.failed and not confirm('swagger-codegen v2.3.0 is already exists. continue anyway?'):
            abort("aborted.")
        local('./run-in-docker.sh mvn package')

def generate_api_client(swagger_json):
    with lcd(swagger_codegen_dir):
        local('rm -rf SwaggerClient-php')
        # TODO: After publishing swagger.json, use that.
        local('cp ' + swagger_json + ' ./colormeshop_swagger.json')
        local('./run-in-docker.sh generate -l php --invoker-package "ColorMeShop\Swagger" -i ./colormeshop_swagger.json')

    local('cp -r ' + swagger_codegen_dir + 'SwaggerClient-php/lib/* src/Swagger/')
