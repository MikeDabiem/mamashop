<div class="user-login">
    <h4 class="login-title font-20-24 fw-600">Авторизація</h4>
    <button class="login__close close-menu">
        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" fill="none"><path stroke="#B4ADAD" stroke-width="2" d="m1.367 1.248 12.767 12.767M14.134 1.248 1.367 14.015"/></svg>
    </button>
    <div class="login__switch transition-default d-flex">
        <button class="login__switch-button login-signin font-16-22 fw-500 transition-default active">Вхід</button>
        <button class="login__switch-button login-signup font-16-22 fw-500 transition-default">Реєстрація</button>
    </div>
    <form name="loginform" id="loginform" class="user-login-form active" action="<?= get_home_url(); ?>/wp-login.php" method="post">
        <p class="login-new-password font-13-16 fw-400 d-none">Тепер Ви можете увійти до свого кабінету використовуючи новий пароль</p>
        <div class="login-username input__wrapper">
            <label for="user_login">Електронна пошта</label>
            <input type="text" name="log" id="user_login" autocomplete="username" class="input" placeholder="Введіть електронну пошту" required>
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <div class="login-password input__wrapper">
            <label for="user_pass">Пароль</label>
            <input type="password" name="pwd" id="user_pass" autocomplete="current-password" spellcheck="false" class="input" placeholder="Введіть свій пароль" required>
            <div class="show-password position-absolute">
                <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                    <path d="M22.4098 14.0549C20.9254 16.4722 17.5944 20.5297 11.9994 20.5297C10.9132 20.5297 9.84053 20.3689 8.81178 20.0508C8.36622 19.9132 8.12028 19.4499 8.26128 19.0151C8.40115 18.5792 8.88046 18.3414 9.32264 18.4768C10.1856 18.7432 11.0858 18.8786 11.9994 18.8786C16.7619 18.8786 19.6587 15.3231 20.9604 13.203C21.4207 12.4589 21.4206 11.5376 20.9626 10.7957C20.5723 10.1539 20.0951 9.49782 19.5796 8.89351C19.2807 8.54236 19.3305 8.02181 19.6903 7.7312C20.0513 7.4395 20.5836 7.48785 20.8825 7.83789C21.4533 8.50826 21.9833 9.23805 22.4142 9.94804C23.1959 11.2106 23.196 12.7869 22.4098 14.0549ZM9.81449 15.2989L2.44527 22.4902C2.28058 22.6509 2.06397 22.7323 1.84739 22.7323C1.63082 22.7323 1.41421 22.652 1.24952 22.4902C0.919011 22.1676 0.919011 21.6447 1.24952 21.3222L4.83099 17.8272C3.333 16.5669 2.2445 15.1216 1.58687 14.0528C0.804036 12.7869 0.803983 11.2107 1.58908 9.94374C3.07353 7.52647 6.40454 3.46898 11.9994 3.46898C14.0693 3.46898 16.0208 4.0402 17.8144 5.15748L21.5525 1.50959C21.883 1.18707 22.4189 1.18707 22.7494 1.50959C23.0799 1.83212 23.0799 2.35502 22.7494 2.67754L9.81669 15.2979C9.81669 15.2979 9.81672 15.2989 9.81559 15.2989C9.81446 15.2989 9.81449 15.2978 9.81449 15.2989ZM9.30226 13.464L13.5009 9.36676C13.0474 9.11689 12.5386 8.97279 11.9994 8.97279C10.2894 8.97279 8.89853 10.33 8.89853 11.9999C8.89853 12.5249 9.04733 13.0215 9.30226 13.464ZM6.02895 16.6572L8.07291 14.6626C7.51454 13.8887 7.20652 12.9697 7.20652 11.9977C7.20652 9.41865 9.35653 7.31949 11.9994 7.31949C12.9966 7.31949 13.9372 7.62007 14.7302 8.16495L16.5701 6.3695C15.1432 5.55383 13.6148 5.1169 11.9994 5.1169C7.23701 5.1169 4.34018 8.67236 3.03846 10.7924C2.57824 11.5365 2.57829 12.4579 3.03626 13.1998C3.642 14.1872 4.64827 15.5223 6.02895 16.6572ZM15.0541 12.4777C14.8511 13.7546 13.7975 14.7837 12.4913 14.9807C12.0299 15.0501 11.713 15.4717 11.7841 15.9219C11.8495 16.3303 12.2093 16.6219 12.6188 16.6219C12.6617 16.6219 12.7057 16.6186 12.7485 16.612C14.8094 16.3016 16.4076 14.742 16.7257 12.7298C16.7968 12.2785 16.481 11.858 16.0185 11.7876C15.5673 11.7204 15.1252 12.0264 15.0541 12.4777Z" />
                </svg>
            </div>
            <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
        </div>
        <div class="login-remember d-flex justify-content-between align-items-center">
            <label class="remember">
                <input name="rememberme" type="checkbox" id="rememberme" class="remember-input transition-default" value="forever">
                <span class="font-14-20 fw-400">Запам’ятати мене</span>
            </label>
            <button type="button" class="lost-password font-14-20 fw-500">Відновити пароль</button>
        </div>
        <section class="login__other">
            <h5 class="login__other-title font-14-20 fw-500 text-center">Увійти за допомогою</h5>
            <div class="login__other__items d-flex">
                <button class="login__other__item">facebook</button>
                <button class="login__other__item">google</button>
                <button class="login__other__item">apple</button>
            </div>
        </section>
        <div class="login-submit">
            <?php wp_nonce_field( 'woocommerce-login', 'woocommerce-login-nonce' ); ?>
            <input type="submit" name="wp-submit" id="wp-submit" class="login-submit-button std-btn purple-btn w-100" value="Увійти">
            <input type="hidden" name="redirect_to" value="<?= get_home_url(); ?>">
        </div>
    </form>
    <form name="registerform" id="registerform" class="user-login-form" autocomplete="off">
        <fieldset>
            <legend class="font-16-22 fw-600">Контактні дані</legend>
            <input type="hidden" name="user_login" id="user_reg_login">
            <input type="hidden" name="display_name" id="user_reg_display_name">
            <div class="input__wrapper">
                <label for="user_reg_firstname">Ім’я<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="text" name="first_name" id="user_reg_firstname" class="reg_input required" placeholder="Введіть ім’я">
                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
            </div>
            <div class="input__wrapper">
                <label for="user_reg_lastname">Прізвище<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="text" name="last_name" id="user_reg_lastname" class="reg_input required" placeholder="Введіть Прізвище">
                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
            </div>
            <div class="input__wrapper">
                <label for="user_reg_email">Електронна пошта<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="email" name="user_email" id="user_reg_email" class="reg_input required" placeholder="Введіть електронну пошту">
                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
            </div>
            <div class="input__wrapper">
                <label for="user_reg_phone">Номер телефону<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="text" name="user_phone" id="user_reg_phone" class="reg_input required" placeholder="Введіть номер телефону">
                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
            </div>
        </fieldset>
        <fieldset>
            <legend class="font-16-22 fw-600">Безпека</legend>
            <div class="input__wrapper">
                <label for="user_reg_password">Придумайте пароль<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="password" name="user_pass" id="user_reg_password" class="reg_input required" autocomplete="new-password">
                <div class="show-password position-absolute">
                    <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M22.4098 14.0549C20.9254 16.4722 17.5944 20.5297 11.9994 20.5297C10.9132 20.5297 9.84053 20.3689 8.81178 20.0508C8.36622 19.9132 8.12028 19.4499 8.26128 19.0151C8.40115 18.5792 8.88046 18.3414 9.32264 18.4768C10.1856 18.7432 11.0858 18.8786 11.9994 18.8786C16.7619 18.8786 19.6587 15.3231 20.9604 13.203C21.4207 12.4589 21.4206 11.5376 20.9626 10.7957C20.5723 10.1539 20.0951 9.49782 19.5796 8.89351C19.2807 8.54236 19.3305 8.02181 19.6903 7.7312C20.0513 7.4395 20.5836 7.48785 20.8825 7.83789C21.4533 8.50826 21.9833 9.23805 22.4142 9.94804C23.1959 11.2106 23.196 12.7869 22.4098 14.0549ZM9.81449 15.2989L2.44527 22.4902C2.28058 22.6509 2.06397 22.7323 1.84739 22.7323C1.63082 22.7323 1.41421 22.652 1.24952 22.4902C0.919011 22.1676 0.919011 21.6447 1.24952 21.3222L4.83099 17.8272C3.333 16.5669 2.2445 15.1216 1.58687 14.0528C0.804036 12.7869 0.803983 11.2107 1.58908 9.94374C3.07353 7.52647 6.40454 3.46898 11.9994 3.46898C14.0693 3.46898 16.0208 4.0402 17.8144 5.15748L21.5525 1.50959C21.883 1.18707 22.4189 1.18707 22.7494 1.50959C23.0799 1.83212 23.0799 2.35502 22.7494 2.67754L9.81669 15.2979C9.81669 15.2979 9.81672 15.2989 9.81559 15.2989C9.81446 15.2989 9.81449 15.2978 9.81449 15.2989ZM9.30226 13.464L13.5009 9.36676C13.0474 9.11689 12.5386 8.97279 11.9994 8.97279C10.2894 8.97279 8.89853 10.33 8.89853 11.9999C8.89853 12.5249 9.04733 13.0215 9.30226 13.464ZM6.02895 16.6572L8.07291 14.6626C7.51454 13.8887 7.20652 12.9697 7.20652 11.9977C7.20652 9.41865 9.35653 7.31949 11.9994 7.31949C12.9966 7.31949 13.9372 7.62007 14.7302 8.16495L16.5701 6.3695C15.1432 5.55383 13.6148 5.1169 11.9994 5.1169C7.23701 5.1169 4.34018 8.67236 3.03846 10.7924C2.57824 11.5365 2.57829 12.4579 3.03626 13.1998C3.642 14.1872 4.64827 15.5223 6.02895 16.6572ZM15.0541 12.4777C14.8511 13.7546 13.7975 14.7837 12.4913 14.9807C12.0299 15.0501 11.713 15.4717 11.7841 15.9219C11.8495 16.3303 12.2093 16.6219 12.6188 16.6219C12.6617 16.6219 12.7057 16.6186 12.7485 16.612C14.8094 16.3016 16.4076 14.742 16.7257 12.7298C16.7968 12.2785 16.481 11.858 16.0185 11.7876C15.5673 11.7204 15.1252 12.0264 15.0541 12.4777Z" />
                    </svg>
                </div>
                <p class="input--error-text font-9-11 fw-400">Заповніть будь ласка поле</p>
            </div>
            <div class="input__wrapper">
                <label for="user_reg_password_repeat">Повторіть пароль<abbr class="text-decoration-none" title="Обов'язкове поле">*</abbr></label>
                <input type="password" name="user_pass_repeat" id="user_reg_password_repeat" class="reg_input required">
                <div class="show-password position-absolute">
                    <svg class="transition-default" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M22.4098 14.0549C20.9254 16.4722 17.5944 20.5297 11.9994 20.5297C10.9132 20.5297 9.84053 20.3689 8.81178 20.0508C8.36622 19.9132 8.12028 19.4499 8.26128 19.0151C8.40115 18.5792 8.88046 18.3414 9.32264 18.4768C10.1856 18.7432 11.0858 18.8786 11.9994 18.8786C16.7619 18.8786 19.6587 15.3231 20.9604 13.203C21.4207 12.4589 21.4206 11.5376 20.9626 10.7957C20.5723 10.1539 20.0951 9.49782 19.5796 8.89351C19.2807 8.54236 19.3305 8.02181 19.6903 7.7312C20.0513 7.4395 20.5836 7.48785 20.8825 7.83789C21.4533 8.50826 21.9833 9.23805 22.4142 9.94804C23.1959 11.2106 23.196 12.7869 22.4098 14.0549ZM9.81449 15.2989L2.44527 22.4902C2.28058 22.6509 2.06397 22.7323 1.84739 22.7323C1.63082 22.7323 1.41421 22.652 1.24952 22.4902C0.919011 22.1676 0.919011 21.6447 1.24952 21.3222L4.83099 17.8272C3.333 16.5669 2.2445 15.1216 1.58687 14.0528C0.804036 12.7869 0.803983 11.2107 1.58908 9.94374C3.07353 7.52647 6.40454 3.46898 11.9994 3.46898C14.0693 3.46898 16.0208 4.0402 17.8144 5.15748L21.5525 1.50959C21.883 1.18707 22.4189 1.18707 22.7494 1.50959C23.0799 1.83212 23.0799 2.35502 22.7494 2.67754L9.81669 15.2979C9.81669 15.2979 9.81672 15.2989 9.81559 15.2989C9.81446 15.2989 9.81449 15.2978 9.81449 15.2989ZM9.30226 13.464L13.5009 9.36676C13.0474 9.11689 12.5386 8.97279 11.9994 8.97279C10.2894 8.97279 8.89853 10.33 8.89853 11.9999C8.89853 12.5249 9.04733 13.0215 9.30226 13.464ZM6.02895 16.6572L8.07291 14.6626C7.51454 13.8887 7.20652 12.9697 7.20652 11.9977C7.20652 9.41865 9.35653 7.31949 11.9994 7.31949C12.9966 7.31949 13.9372 7.62007 14.7302 8.16495L16.5701 6.3695C15.1432 5.55383 13.6148 5.1169 11.9994 5.1169C7.23701 5.1169 4.34018 8.67236 3.03846 10.7924C2.57824 11.5365 2.57829 12.4579 3.03626 13.1998C3.642 14.1872 4.64827 15.5223 6.02895 16.6572ZM15.0541 12.4777C14.8511 13.7546 13.7975 14.7837 12.4913 14.9807C12.0299 15.0501 11.713 15.4717 11.7841 15.9219C11.8495 16.3303 12.2093 16.6219 12.6188 16.6219C12.6617 16.6219 12.7057 16.6186 12.7485 16.612C14.8094 16.3016 16.4076 14.742 16.7257 12.7298C16.7968 12.2785 16.481 11.858 16.0185 11.7876C15.5673 11.7204 15.1252 12.0264 15.0541 12.4777Z" />
                    </svg>
                </div>
                <p class="input--error-text font-9-11 fw-400">Паролі не співпадають</p>
            </div>
        </fieldset>
        <label class="remember">
            <input name="reg_rememberme" type="checkbox" id="reg_rememberme" class="remember-input transition-default" value="forever">
            <span class="font-14-20 fw-400">Запам’ятати мене</span>
        </label>
        <button type="submit" class="register-submit-button std-btn purple-btn font-16-22 fw-600 transition-default w-100">Зареєструватись</button>
    </form>
</div>