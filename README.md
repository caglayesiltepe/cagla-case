# Task Distribution Case

Symfony framework'ü kullanarak geliştirilmiş bir projeyi Docker kullanarak yerel ortamınızda çalıştırmak için adımları
içerir.

## Gereksinimler

Projeyi çalıştırmak için yerel bilgisayarınızda aşağıdaki gereksinimlerin yüklü olması gerekmektedir:

- [Docker](https://www.docker.com/)
- [Docker Compose](https://docs.docker.com/compose/)

## Kurulum

1. Bu depoyu yerel makinenize klonlayın:

    ```bash
    git clone git@bitbucket.org:easycep/easycep-ecommerce.git
    ```

2. Terminal veya Komut İstemi'ni açın ve proje dizinine gidin:

    ```bash
    cd example_case
    ```

3. Docker container'larını başlatmak için aşağıdaki komutu çalıştırın:

    ```bash
    docker compose up -d --build
    ```

4. Environment dosyası yoksa oluşturun ve .env.test içeriğini .env içine yapıştırın:

    ```bash
    cp .env .env.local
    ```
5. İlgili containera giriş yapın 
    ```bash
    docker exec -ti symfony_php sh
    ```
   
6. Migration dosylarını çalıştırın:
    ```bash
    php bin/console doctrine:migrations:migrate
    ```
   
7. Tablolara ilgili verileri çekmek için console taskı çalıştırın
    ```bash
    php bin/console app:fetch-tasks
    ```
   
8. İlgili sayfaya gidip iş dağılımı listesini görüntüleyin
    ```bash
    http://localhost:8080/task
    ```