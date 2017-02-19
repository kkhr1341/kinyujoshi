from fabric.api import sudo, run, cd

def deploy():
    with cd("/home/apache/host/kinyujyoshi"):
        run("git reset --hard");
        run("git pull");