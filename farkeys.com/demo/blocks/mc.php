<form action="use-mc.php" method="post" style="margin-bottom: 5px;">
                                <div style="margin-bottom: 15px;">
                                    <strong>Мастер-код</strong>
                                </div>

                                   <label class="input-control checkbox">
                                        <input type="checkbox" value="1" name="usemc"<?=( $row->usemc == 1 )? ' checked="checked"' : '';?> />
                                        <span class="helper">Использовать Мастер-код</span>
                                    </label>

                                <div class="input-control text">
                                    <div class="fg-color-darken" style="margin:0 0 5px 0;">Установить новый Мастер-код</div>
                                    <input type="text" maxlength="255" name="master" value="" />
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