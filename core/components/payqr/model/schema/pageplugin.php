<div class="section-payqr">

<div class="widget-table-body">
    <div class="wrapper-slider-setting">
        <div class="widget-table-action slide-settings">
            <div class="clear"></div>
            <div class="slide-settings-table-wrapper">
                <table class="widget-table">
                    <thead>
                    <tr>
                        <th style="width:40px">Свойство кнопки</th>
                        <th style="width:100px; text-align: center;">Тип</th>
                    </tr>
                    </thead>
                    <tbody class="entity-table-tbody"> 
                    <?php if(empty($entity)) { ?>
                        <tr class="no-results">
                            <td colspan="2" align="center"><?php echo $lang['ENTITY_NONE'];?></td>
                        </tr>
                    <?php } else { ?>
                        <tr>
                            <td><?php echo $lang['payqr_merchant_id'];?>:</td>
                            <td><input type="text" name="payqr_merchant_id" class="field" value="<?php echo $entity->payqr_merchant_id; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_merchant_secret_key_in'];?>:</td>
                            <td><input type="text" name="payqr_merchant_secret_key_in" class="field" value="<?php echo $entity->payqr_merchant_secret_key_in; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_merchant_secret_key_out'];?>:</td>
                            <td><input type="text" name="payqr_merchant_secret_key_out" class="field" value="<?php echo $entity->payqr_merchant_secret_key_out; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_hook_handler_url'];?>:</td>
                            <td><input type="text" name="payqr_hook_handler_url" class="field" value="<?php echo $entity->payqr_hook_handler_url; ?>" size="40" disabled></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_log_url'];?>:</td>
                            <td><input type="text" name="payqr_log_url" class="field" value="<?php echo $entity->payqr_log_url; ?>" size="40" disabled></td>
                        </tr>
                        
                        <tr><td colspan="2"><hr></td></tr>

                        <tr>
                            <td><?php echo $lang['payqr_button_show_on_cart'];?>:</td>
                            <td>
                                <select name="payqr_button_show_on_cart">
                                    <option value="yes" <?php if($entity->payqr_button_show_on_cart=="yes") echo "selected";  ?>><?php echo $lang["yes"];?></option>
                                    <option value="no" <?php if($entity->payqr_button_show_on_cart=="no") echo "selected";  ?>><?php echo $lang["no"];?></option>
                                </select>
                            </td>
                        </tr>
                        <?php if($entity->payqr_button_show_on_cart=="yes") { ?>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_color'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_color">
                                        <option value="default" <?php if($entity->payqr_cart_button_color=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="green" <?php if($entity->payqr_cart_button_color=="green") echo "selected";  ?>><?php echo $lang["green"];?></option>
                                        <option value="red" <?php if($entity->payqr_cart_button_color=="red") echo "selected";  ?>><?php echo $lang["red"];?></option>
                                        <option value="blue" <?php if($entity->payqr_cart_button_color=="blue") echo "selected";  ?>><?php echo $lang["blue"];?></option>
                                        <option value="orange" <?php if($entity->payqr_cart_button_color=="orange") echo "selected";  ?>><?php echo $lang["orange"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_form'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_form">
                                        <option value="default" <?php if($entity->payqr_cart_button_form=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="sharp" <?php if($entity->payqr_cart_button_form=="sharp") echo "selected";  ?>><?php echo $lang["sharp"];?></option>
                                        <option value="rude" <?php if($entity->payqr_cart_button_form=="rude") echo "selected";  ?>><?php echo $lang["rude"];?></option>
                                        <option value="soft" <?php if($entity->payqr_cart_button_form=="soft") echo "selected";  ?>><?php echo $lang["soft"];?></option>
                                        <option value="sleek" <?php if($entity->payqr_cart_button_form=="sleek") echo "selected";  ?>><?php echo $lang["sleek"];?></option>
                                        <option value="oval" <?php if($entity->payqr_cart_button_form=="oval") echo "selected";  ?>><?php echo $lang["oval"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_shadow'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_shadow">
                                        <option value="default" <?php if($entity->payqr_cart_button_shadow=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="shadow" <?php if($entity->payqr_cart_button_shadow=="shadow") echo "selected";  ?>><?php echo $lang["shadow"];?></option>
                                        <option value="noshadow" <?php if($entity->payqr_cart_button_shadow=="noshadow") echo "selected";  ?>><?php echo $lang["noshadow"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_gradient'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_gradient">
                                        <option value="default" <?php if($entity->payqr_cart_button_gradient=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="flat" <?php if($entity->payqr_cart_button_gradient=="flat") echo "selected";  ?>><?php echo $lang["flat"];?></option>
                                        <option value="gradient" <?php if($entity->payqr_cart_button_gradient=="gradient") echo "selected";  ?>><?php echo $lang["gradient"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_font_trans'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_font_trans">
                                        <option value="default" <?php if($entity->payqr_cart_button_font_trans=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="small" <?php if($entity->payqr_cart_button_font_trans=="small") echo "selected";  ?>><?php echo $lang["small"];?></option>
                                        <option value="medium" <?php if($entity->payqr_cart_button_font_trans=="medium") echo "selected";  ?>><?php echo $lang["medium"];?></option>
                                        <option value="large" <?php if($entity->payqr_cart_button_font_trans=="large") echo "selected";  ?>><?php echo $lang["large"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_font_width'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_font_width">
                                        <option value="default" <?php if($entity->payqr_cart_button_font_width=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="normal" <?php if($entity->payqr_cart_button_font_width=="normal") echo "selected";  ?>><?php echo $lang["normal"];?></option>
                                        <option value="bold" <?php if($entity->payqr_cart_button_font_width=="bold") echo "selected";  ?>><?php echo $lang["bold"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_text_case'];?>:</td>
                                <td>
                                    <select name="payqr_cart_button_text_case">
                                        <option value="default" <?php if($entity->payqr_cart_button_text_case=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="lowercase" <?php if($entity->payqr_cart_button_text_case=="lowercase") echo "selected";  ?>><?php echo $lang["lowercase"];?></option>
                                        <option value="standartcase" <?php if($entity->payqr_cart_button_text_case=="standartcase") echo "selected";  ?>><?php echo $lang["standartcase"];?></option>
                                        <option value="uppercase" <?php if($entity->payqr_cart_button_text_case=="uppercase") echo "selected";  ?>><?php echo $lang["uppercase"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_height'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_cart_button_height" class="field" value="<?php if($entity->payqr_cart_button_height=="") echo "auto";  ?><?php if($entity->payqr_cart_button_height!="")echo $entity->payqr_cart_button_height; ?>" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_cart_button_width'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_cart_button_width" class="field" value="<?php if($entity->payqr_cart_button_width=="") echo "auto";  ?><?php if($entity->payqr_cart_button_width!="")echo $entity->payqr_cart_button_width; ?>" size="40">
                                </td>
                            </tr>
                        <?php } ?>


                        <tr><td colspan="2"><hr></td></tr>

                        <tr>
                            <td><?php echo $lang['payqr_button_show_on_product'];?>:</td>
                            <td>
                                <select name="payqr_button_show_on_product">
                                    <option value="yes" <?php if($entity->payqr_button_show_on_product=="yes") echo "selected";  ?>><?php echo $lang["yes"];?></option>
                                    <option value="no" <?php if($entity->payqr_button_show_on_product=="no") echo "selected";  ?>><?php echo $lang["no"];?></option>
                                </select>
                            </td>
                        </tr>
                        <?php if($entity->payqr_button_show_on_product=="yes") { ?>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_color'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_color">
                                        <option value="default" <?php if($entity->payqr_product_button_color=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="green" <?php if($entity->payqr_product_button_color=="green") echo "selected";  ?>><?php echo $lang["green"];?></option>
                                        <option value="red" <?php if($entity->payqr_product_button_color=="red") echo "selected";  ?>><?php echo $lang["red"];?></option>
                                        <option value="blue" <?php if($entity->payqr_product_button_color=="blue") echo "selected";  ?>><?php echo $lang["blue"];?></option>
                                        <option value="orange" <?php if($entity->payqr_product_button_color=="orange") echo "selected";  ?>><?php echo $lang["orange"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_form'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_form">
                                        <option value="default" <?php if($entity->payqr_product_button_form=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="sharp" <?php if($entity->payqr_product_button_form=="sharp") echo "selected";  ?>><?php echo $lang["sharp"];?></option>
                                        <option value="rude" <?php if($entity->payqr_product_button_form=="rude") echo "selected";  ?>><?php echo $lang["rude"];?></option>
                                        <option value="soft" <?php if($entity->payqr_product_button_form=="soft") echo "selected";  ?>><?php echo $lang["soft"];?></option>
                                        <option value="sleek" <?php if($entity->payqr_product_button_form=="sleek") echo "selected";  ?>><?php echo $lang["sleek"];?></option>
                                        <option value="oval" <?php if($entity->payqr_product_button_form=="oval") echo "selected";  ?>><?php echo $lang["oval"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_shadow'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_shadow">
                                        <option value="default" <?php if($entity->payqr_product_button_shadow=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="shadow" <?php if($entity->payqr_product_button_shadow=="shadow") echo "selected";  ?>><?php echo $lang["shadow"];?></option>
                                        <option value="noshadow" <?php if($entity->payqr_product_button_shadow=="noshadow") echo "selected";  ?>><?php echo $lang["noshadow"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_gradient'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_gradient">
                                        <option value="default" <?php if($entity->payqr_product_button_gradient=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="flat" <?php if($entity->payqr_product_button_gradient=="flat") echo "selected";  ?>><?php echo $lang["flat"];?></option>
                                        <option value="gradient" <?php if($entity->payqr_product_button_gradient=="gradient") echo "selected";  ?>><?php echo $lang["gradient"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_font_trans'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_font_trans">
                                        <option value="default" <?php if($entity->payqr_product_button_font_trans=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="small" <?php if($entity->payqr_product_button_font_trans=="small") echo "selected";  ?>><?php echo $lang["small"];?></option>
                                        <option value="medium" <?php if($entity->payqr_product_button_font_trans=="medium") echo "selected";  ?>><?php echo $lang["medium"];?></option>
                                        <option value="large" <?php if($entity->payqr_product_button_font_trans=="large") echo "selected";  ?>><?php echo $lang["large"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_font_width'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_font_width">
                                        <option value="default" <?php if($entity->payqr_product_button_font_width=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="normal" <?php if($entity->payqr_product_button_font_width=="normal") echo "selected";  ?>><?php echo $lang["normal"];?></option>
                                        <option value="bold" <?php if($entity->payqr_product_button_font_width=="bold") echo "selected";  ?>><?php echo $lang["bold"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_text_case'];?>:</td>
                                <td>
                                    <select name="payqr_product_button_text_case">
                                        <option value="default" <?php if($entity->payqr_product_button_text_case=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="lowercase" <?php if($entity->payqr_product_button_text_case=="lowercase") echo "selected";  ?>><?php echo $lang["lowercase"];?></option>
                                        <option value="standartcase" <?php if($entity->payqr_product_button_text_case=="standartcase") echo "selected";  ?>><?php echo $lang["standartcase"];?></option>
                                        <option value="uppercase" <?php if($entity->payqr_product_button_text_case=="uppercase") echo "selected";  ?>><?php echo $lang["uppercase"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_height'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_product_button_height" class="field" value="<?php if($entity->payqr_product_button_height=="") echo "auto";  ?><?php if($entity->payqr_product_button_height!="")echo $entity->payqr_product_button_height; ?>" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_product_button_width'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_product_button_width" class="field" value="<?php if($entity->payqr_product_button_width=="") echo "auto";  ?><?php if($entity->payqr_product_button_width!="")echo $entity->payqr_product_button_width; ?>" size="40">
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <tr><td colspan="2"><hr></td></tr>

                        <tr>
                            <td><?php echo $lang['payqr_button_show_on_category'];?>:</td>
                            <td>
                                <select name="payqr_button_show_on_category">
                                    <option value="yes" <?php if($entity->payqr_button_show_on_category=="yes") echo "selected";  ?>><?php echo $lang["yes"];?></option>
                                    <option value="no" <?php if($entity->payqr_button_show_on_category=="no") echo "selected";  ?>><?php echo $lang["no"];?></option>
                                </select>
                            </td>
                        </tr>
                        <?php if($entity->payqr_button_show_on_category=="yes") { ?>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_color'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_color">
                                        <option value="default" <?php if($entity->payqr_category_button_color=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="green" <?php if($entity->payqr_category_button_color=="green") echo "selected";  ?>><?php echo $lang["green"];?></option>
                                        <option value="red" <?php if($entity->payqr_category_button_color=="red") echo "selected";  ?>><?php echo $lang["red"];?></option>
                                        <option value="blue" <?php if($entity->payqr_category_button_color=="blue") echo "selected";  ?>><?php echo $lang["blue"];?></option>
                                        <option value="orange" <?php if($entity->payqr_category_button_color=="orange") echo "selected";  ?>><?php echo $lang["orange"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_form'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_form">
                                        <option value="default" <?php if($entity->payqr_category_button_form=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="sharp" <?php if($entity->payqr_category_button_form=="sharp") echo "selected";  ?>><?php echo $lang["sharp"];?></option>
                                        <option value="rude" <?php if($entity->payqr_category_button_form=="rude") echo "selected";  ?>><?php echo $lang["rude"];?></option>
                                        <option value="soft" <?php if($entity->payqr_category_button_form=="soft") echo "selected";  ?>><?php echo $lang["soft"];?></option>
                                        <option value="sleek" <?php if($entity->payqr_category_button_form=="sleek") echo "selected";  ?>><?php echo $lang["sleek"];?></option>
                                        <option value="oval" <?php if($entity->payqr_category_button_form=="oval") echo "selected";  ?>><?php echo $lang["oval"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_shadow'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_shadow">
                                        <option value="default" <?php if($entity->payqr_category_button_shadow=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="shadow" <?php if($entity->payqr_category_button_shadow=="shadow") echo "selected";  ?>><?php echo $lang["shadow"];?></option>
                                        <option value="noshadow" <?php if($entity->payqr_category_button_shadow=="noshadow") echo "selected";  ?>><?php echo $lang["noshadow"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_gradient'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_gradient">
                                        <option value="default" <?php if($entity->payqr_category_button_gradient=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="flat" <?php if($entity->payqr_category_button_gradient=="flat") echo "selected";  ?>><?php echo $lang["flat"];?></option>
                                        <option value="gradient" <?php if($entity->payqr_category_button_gradient=="gradient") echo "selected";  ?>><?php echo $lang["gradient"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_font_trans'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_font_trans">
                                        <option value="default" <?php if($entity->payqr_category_button_font_trans=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="small" <?php if($entity->payqr_category_button_font_trans=="small") echo "selected";  ?>><?php echo $lang["small"];?></option>
                                        <option value="medium" <?php if($entity->payqr_category_button_font_trans=="medium") echo "selected";  ?>><?php echo $lang["medium"];?></option>
                                        <option value="large" <?php if($entity->payqr_category_button_font_trans=="large") echo "selected";  ?>><?php echo $lang["large"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_font_width'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_font_width">
                                        <option value="default" <?php if($entity->payqr_category_button_font_width=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="normal" <?php if($entity->payqr_category_button_font_width=="normal") echo "selected";  ?>><?php echo $lang["normal"];?></option>
                                        <option value="bold" <?php if($entity->payqr_category_button_font_width=="bold") echo "selected";  ?>><?php echo $lang["bold"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_text_case'];?>:</td>
                                <td>
                                    <select name="payqr_category_button_text_case">
                                        <option value="default" <?php if($entity->payqr_category_button_text_case=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                        <option value="lowercase" <?php if($entity->payqr_category_button_text_case=="lowercase") echo "selected";  ?>><?php echo $lang["lowercase"];?></option>
                                        <option value="standartcase" <?php if($entity->payqr_category_button_text_case=="standartcase") echo "selected";  ?>><?php echo $lang["standartcase"];?></option>
                                        <option value="uppercase" <?php if($entity->payqr_category_button_text_case=="uppercase") echo "selected";  ?>><?php echo $lang["uppercase"];?></option>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_height'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_category_button_height" class="field" value="<?php if($entity->payqr_category_button_height=="") echo "auto";  ?><?php if($entity->payqr_category_button_height!="")echo $entity->payqr_category_button_height; ?>" size="40">
                                </td>
                            </tr>
                            <tr>
                                <td><?php echo $lang['payqr_category_button_width'];?>:</td>
                                <td>
                                    <input type="text" name="payqr_category_button_width" class="field" value="<?php if($entity->payqr_category_button_width=="") echo "auto";  ?><?php if($entity->payqr_category_button_width!="")echo $entity->payqr_category_button_width; ?>" size="40">
                                </td>
                            </tr>
                        <?php } ?>
                        
                        <tr><td colspan="2"><hr></td></tr>

                        <tr>
                            <td><?php echo $lang['payqr_status_creatted'];?>:</td>
                            <td>
                                <input type="text" name="payqr_status_creatted" class="field" value="<?php if($entity->payqr_status_creatted=="")echo "0"; ?><?php if($entity->payqr_status_creatted!="")echo $entity->payqr_status_creatted; ?>" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_status_paid'];?>:</td>
                            <td>
                                <input type="text" name="payqr_status_paid" class="field" value="<?php if($entity->payqr_status_paid=="")echo "2"; ?><?php if($entity->payqr_status_paid!="")echo $entity->payqr_status_paid; ?>" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_status_cancelled'];?>:</td>
                            <td>
                                <input type="text" name="payqr_status_cancelled" class="field" value="<?php if($entity->payqr_status_cancelled=="")echo "4"; ?><?php if($entity->payqr_status_cancelled!="")echo $entity->payqr_status_cancelled; ?>" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_status_completed'];?>:</td>
                            <td>
                                <input type="text" name="payqr_status_completed" class="field" value="<?php if($entity->payqr_status_completed=="")echo "5"; ?><?php if($entity->payqr_status_completed!="")echo $entity->payqr_status_completed; ?>" size="40">
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_firstname'];?>:</td>
                            <td>
                                <select name="payqr_require_firstname">
                                    <option value="default" <?php if($entity->payqr_require_firstname=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_firstname=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_firstname=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_lastname'];?>:</td>
                            <td>
                                <select name="payqr_require_lastname">
                                    <option value="default" <?php if($entity->payqr_require_lastname=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_lastname=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_lastname=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_middlename'];?>:</td>
                            <td>
                                <select name="payqr_require_middlename">
                                    <option value="default" <?php if($entity->payqr_require_middlename=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_middlename=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_middlename=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_phone'];?>:</td>
                            <td>
                                <select name="payqr_require_phone">
                                    <option value="default" <?php if($entity->payqr_require_phone=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_phone=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_phone=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_email'];?>:</td>
                            <td>
                                <select name="payqr_require_email" disabled>
                                    <option value="default" <?php if($entity->payqr_require_email=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_email=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_email=="required") echo "selected";  ?> selected><?php echo $lang["required"];?></option>
                                </select>
                                <input type="hidden" name="payqr_require_email" value="required" />
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_delivery'];?>:</td>
                            <td>
                                <select name="payqr_require_delivery">
                                    <option value="default" <?php if($entity->payqr_require_delivery=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_delivery=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_delivery=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_deliverycases'];?>:</td>
                            <td>
                                <select name="payqr_require_deliverycases">
                                    <option value="default" <?php if($entity->payqr_require_deliverycases=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_deliverycases=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_deliverycases=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_pickpoints'];?>:</td>
                            <td>
                                <select name="payqr_require_pickpoints" disabled>
                                    <option value="default" <?php if($entity->payqr_require_pickpoints=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_pickpoints=="deny") echo "selected";  ?> selected><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_pickpoints=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                            <input type="hidden" name="payqr_require_pickpoints" value="deny" />
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_require_promo'];?>:</td>
                            <td>
                                <select name="payqr_require_promo">
                                    <option value="default" <?php if($entity->payqr_require_promo=="default") echo "selected";  ?>><?php echo $lang["default"];?></option>
                                    <option value="deny" <?php if($entity->payqr_require_promo=="deny") echo "selected";  ?>><?php echo $lang["deny"];?></option>
                                    <option value="required" <?php if($entity->payqr_require_promo=="required") echo "selected";  ?>><?php echo $lang["required"];?></option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_promo_code'];?>:</td>
                            <td><input type="text" name="payqr_promo_code" class="field" value="<?php echo $entity->payqr_promo_code; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_user_message_text'];?>:</td>
                            <td><input type="text" name="payqr_user_message_text" class="field" value="<?php echo $entity->payqr_user_message_text; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_user_message_imageurl'];?>:</td>
                            <td><input type="text" name="payqr_user_message_imageurl" class="field" value="<?php echo $entity->payqr_user_message_imageurl; ?>" size="40"></td>
                        </tr>
                        <tr>
                            <td><?php echo $lang['payqr_user_message_url'];?>:</td>
                            <td><input type="text" name="payqr_user_message_url" class="field" value="<?php echo $entity->payqr_user_message_url; ?>" size="40"></td>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
                <button class="tool-tip-bottom base-setting-save save-button custom-btn" data-id="" title="<?php echo $lang['SAVE_MODAL'] ?>"><!-- Кннопка действия -->
                    <span><?php echo $lang['SAVE_MODAL'] ?></span>
                </button>
            </div>
        </div>
</div>