# User, Group, File, Ssh
## Tạo ở máy em 3 user user-A, user-B, user-C và 2 group group-A, group-B
- sudo useradd -m -c "user-A" user-A
- sudo useradd -m -c "user-B" user-B
- sudo useradd -m -c "user-C" user-C
![](./images/useradd.png)
- sudo groupadd group-A
- sudo groupadd group-B
![](./images/groupadd.png)

## Cho user-A, user-B vào group-1, user-C vào group-2
- sudo usermod -g group-A user-A
- sudo usermod -g group-A user-B
- sudo usermod -g group-B user-C
![](./images/groupadd.png)

## Tạo 1 file example.txt với phân quyền user-A có  read write exec, group-2 chỉ có read và exec. Các user còn lại có thể read.  Thử login vào user-C và sửa đổi file example.txt điều gì sẽ xảy ra?