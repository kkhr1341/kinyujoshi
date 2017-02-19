from fabric.api import sudo, run, cd

def deploy():
    with cd("/home/apache/host/dev_kinyujyoshi"):
        run("git reset --hard");
        run("git pull");
        run("cp -r web/public/.htaccess_dev web/public/.htaccess")