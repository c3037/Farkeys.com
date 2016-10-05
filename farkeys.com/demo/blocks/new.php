                            <form action="new_fk_id.php" method="post" style="margin-bottom: 5px;">
                                <div style="margin-bottom: 15px;">
                                    <strong>Привязать новый FARKeys ID</strong>
                                </div>
                                <div class="input-control text">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">E-mail адрес в системе FARKeys:</div>
                                    <input type="text" maxlength="255" name="email" value="" />
                                </div>
                                <div class="input-control password">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">Текущий пароль:</div>
                                    <input type="password" maxlength="255" name="password" value="" />
                                </div>
                                <div>
                                    <input type="hidden" name="query" value="1" />
                                    <input type="submit" value="Отправить" />
                                </div>
                            </form>