<?php
            }
            else
            {
            ?>
            <span class="card-title">Register</span>
            <br>
            <form method="post">                      
              <div class="input-field">
                <label for="login">핸드폰번호</label>
                <input type="text" name="user_mobile" id="user_mobile" placeholder="핸드폰 번호를 입력해 주세요." class="form-control">
              </div>
              <div class="input-field">
                <label for="login">사용자명</label>
                <input type="text" name="user_name" id="user_name" placeholder="사용자 이름을 입력해 주세요." class="form-control">
              </div>
              <div class="input-field">
                <label for="password">비밀번호</label>
                <input type="password" name="user_password" id="user_password" placeholder="비밀번호를 입력해 주세요." class="form-control">
              </div>
              <div class="row">
                <div class="card-action">                
                  <input type="submit" id="login" name="login" value="LOG IN" class="btn right">
                  <input type="submit" id="register" name="register" value="Register" class="btn right red">`
                </div>
              </div>
              <p><?php echo $message; ?></p>
            </form>
            <?php
            }
            ?>  