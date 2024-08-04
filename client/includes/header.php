<?php
include_once ("./DBUntil.php");
$dbHelper = new DBUntil();
session_start();


?>
<header>
    <div class="header container d-flex justify-content-between align-items-center py-3">
        <div class="logo-image">
            <a href="index.php">
                <img src="./image/logo.png" alt>
            </a>
        </div>
        <?php include "nav.php" ?>
        <div class="header-search">
            <button>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                    class="lucide lucide-search">
                    <circle cx="11" cy="11" r="8" />
                    <path d="m21 21-4.3-4.3" />
                </svg>
            </button>
            <input type="search" name="search" class="search" placeholder="Bạn tìm gì...">
        </div>
        <div class="cart-user">
            <ul class="d-flex justify-content-between align-items-center">
                <li class="nav-link mx-2">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-heart">
                            <path
                                d="M19 14c1.49-1.46 3-3.21 3-5.5A5.5 5.5 0 0 0 16.5 3c-1.76 0-3 .5-4.5 2-1.5-1.5-2.74-2-4.5-2A5.5 5.5 0 0 0 2 8.5c0 2.3 1.5 4.05 3 5.5l7 7Z" />
                        </svg>
                    </a>
                </li>
                <li class="nav-link mx-2">
                    <a href="#">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                            class="lucide lucide-shopping-bag">
                            <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                            <path d="M3 6h18" />
                            <path d="M16 10a4 4 0 0 1-8 0" />
                        </svg>
                    </a>
                </li>
                <li class="nav-link mx-2">
                    <?php if (!isset($_SESSION['id'])) { 
                        
                        echo ' 
                            <a href="login.php">
                                <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-user-round">
                                    <circle cx="12" cy="8" r="5" />
                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                </svg>
                            </a>
                        '; }  else { 
                                $idUser = $_SESSION['id'];
                                $users = $dbHelper->select("SELECT * FROM users WHERE idUser = $idUser");
                                $image = $users[0]['image'];
                            
                             if(empty($image)){
                                    $image = "avt.png";
                                }
                            echo '

                        <div class="dropdown">
                            <button class="btn-dropdown p-0" onclick="showDropdown()">
                                <img style="width: 42px; height: 42px;" src="../admin/users/image/'.$image.'" alt>
                            </button>
                            <ul class="dropdown-menu mt-1">
                                <li>
                                    <a class="dropdown-item" href="./accountInformation.php?id='.$idUser.'">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-user-round">
                                            <circle cx="12" cy="8" r="5" />
                                            <path d="M20 21a8 8 0 0 0-16 0" />
                                        </svg>
                                        Thông tin tài khoản
                                    </a>
                                </li>
                                <li><a class="dropdown-item" href="logout.php">
                                        <i class="fa-solid fa-right-from-bracket mx-1"></i>
                                        Đăng xuất
                                    </a></li>
                            </ul>
                        </div>
                        '; } ?>
                </li>
            </ul>
        </div>
    </div>
    <div class="container-fluid p-0">
        <div class="d-flex justify-content-center align-items-center header-outstanding">
            <p class="link-cate m-2 fw-bold">BE CONFIDENT - <a href="#">OUT NOW</a></p>
        </div>
    </div>
</header>