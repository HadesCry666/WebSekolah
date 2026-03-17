node {

    checkout scm

    stage("Build") {
        docker.image('composer:2.7').inside('--entrypoint="" -u root') {
            sh 'composer install --no-scripts'
        }
    }

    stage("Testing") {
        docker.image('php:8.1-cli').inside('-u root') {
            sh 'php -v'
        }
    }

    stage("Deploy Production") {
        docker.image('agung3wi/alpine-rsync:1.1').inside('-u root') {

            sshagent (credentials: ['ssh-jenkins']) {

                sh '''
                if [ -z "$PROD_HOST" ]; then
                    echo "PROD_HOST tidak diset. Skip deploy."
                    exit 0
                fi

                mkdir -p ~/.ssh

                # ambil fingerprint host (jika host tidak aktif tidak membuat pipeline gagal)
                ssh-keyscan -H $PROD_HOST >> ~/.ssh/known_hosts 2>/dev/null || true

                # deploy menggunakan rsync
                rsync -rav --delete ./ \
                ubuntu@$PROD_HOST:/home/ubuntu/prod.kelasdevops.xyz/ \
                --exclude=.env \
                --exclude=storage \
                --exclude=.git || true
                '''
            }
        }
    }

}