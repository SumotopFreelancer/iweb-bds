<div id="real-search" class="search bg-img lazy py-40 d-none d-md-block" data-src="<?= public_url('dist/images/khung-search.png') ?>">
    <div class="container">
        <div class="d-md-none d-block">
            <div class="text-lg mb-15">Tìm kiếm bất động sản</div>
            <div class="close-search p-3">
                <i class="iwe iwe-close-light"></i>
            </div>
        </div>
        <div class="box-search px-15 py-15 rounded-sm">
            <div class="search-control bg-white rounded-sm">
                <div class="search-cate">
                    <div class="select-custom">
                        <?php
                        if ($this->input->get('type') == 'cate') {
                            $cateUrl = $this->uri->rsegment(3);
                            $cateName = $this->catalog_model->get_info_rule(['url' => $cateUrl, 'status' => 1], 'name')->name;
                        }
                        ?>
                        <input id="cateValue" type="hidden" name="catalog_id" value="<?= !empty($cateUrl) ? $cateUrl : '' ?>">
                        <div id="lblCurrCate" class="strong lblCurrCate"><?= !empty($cateName) ? $cateName : 'Loại nhà đất' ?></div>
                    </div>
                    <div id="divCatagoryReOptions" class="advance-select-options bg-white">
                        <ul>
                            <li data-id="0">Loại nhà đất</li>
                            <?php if (!empty($cateSearch)) : ?>
                                <?php foreach ($cateSearch as $row) : ?>
                                    <li data-id="<?= $row->url ?>" <?php /* (!empty($cateUrl) && $cateUrl == $row->url) ? 'class="strong"' : '' */ ?>><?= $row->name ?></li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                    </div>
                </div>
                <div class="search-input">
                    <input type="text" id="txtSearch" placeholder="Nhập thông tin tìm kiếm" autocomplete="off" aria-autocomplete="list" aria-haspopup="true" name="txtSearch" class="ui-autocomplete-input" value="<?= $this->input->get('txtSearch') ?>">
                </div>
                <div class="search-button">
                    <button type="button" class="btn-search ibg-primary text-white" id="btnSearch"><strong><i class="iwe iwe-search-white mr-10"></i>TÌM KIẾM</strong></button>
                </div>
                <div class="clearfix"></div>
            </div>
            <div class="row">
                <div class="col-20 col-md-6 col-sm-12 mt-15">
                    <div class="wSelectCustom">
                        <div class="select-custom">
                            <?php
                            if ($this->input->get('price_id')) {
                                $priceInfo = $this->price_model->get_info($this->input->get('price_id'));
                                if ($priceInfo) {
                                    $priceName = $priceInfo->price_from . '<i class="iwe iwe-arrow-right-long-dark mx-10"></i>' . $priceInfo->price_to . ' tỷ';
                                }
                            }
                            ?>
                            <input class="importValue" type="hidden" name="price_id" value="<?= $this->input->get('price_id') ?>">
                            <div class="b importText text-white"><?= !empty($priceName) ? $priceName : '-- Chọn mức giá --' ?></div>
                        </div>
                        <div class="listSelect ibg-3">
                            <ul>
                                <li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn mức giá --</li>
                                <?php if (!empty($priceSearch)) : ?>
                                    <?php foreach ($priceSearch as $row) : ?>
                                        <li data-id="<?= $row->id ?>" data-type="default" class="itext-9 <?php /* $this->input->get('price_id') == $row->id ? 'choose' : '' */ ?>" onclick="get_val_data(this)">
                                            <?= $row->price_from ?><i class="iwe iwe-arrow-right-long-dark mx-10"></i><?= $row->price_to ?> tỷ
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-20 col-md-6 col-sm-12 mt-15">
                    <div class="wSelectCustom">
                        <?php
                        if ($this->input->get('area_id')) {
                            $areaInfo = $this->area_model->get_info($this->input->get('area_id'));
                            if ($areaInfo) {
                                if ($areaInfo->area_from == 0) {
                                    $areaName = '<= ' . $areaInfo->area_to . ' m2';
                                } elseif ($areaInfo->area_to == 0) {
                                    $areaName = '>= ' . $areaInfo->area_from . ' m2';
                                } else {
                                    $areaName = $areaInfo->area_from . ' - ' . $areaInfo->area_to . ' m2';
                                }
                            }
                        }
                        ?>
                        <div class="select-custom">
                            <input class="importValue" type="hidden" name="area_id" value="<?= $this->input->get('area_id') ?>">
                            <div class="b importText text-white"><?= !empty($areaName) ? $areaName : '-- Chọn diện tích --' ?></div>
                        </div>
                        <div class="listSelect ibg-3">
                            <ul>
                                <li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn mức giá --</li>
                                <?php if (!empty($areaSearch)) : ?>
                                    <?php foreach ($areaSearch as $row) : ?>
                                        <li data-id="<?= $row->id ?>" data-type="default" class="itext-9 <?php /* $this->input->get('area_id') == $row->id ? 'choose' : '' */ ?>" onclick="get_val_data(this)">
                                            <?php if ($row->area_from == 0) : ?>
                                                <?= '<= ' . $row->area_to ?> m2
                                            <?php elseif ($row->area_to == 0) : ?>
                                                <?= '>= ' . $row->area_from ?> m2
                                            <?php else : ?>
                                                <?= $row->area_from ?> - <?= $row->area_to ?> m2
                                            <?php endif; ?>
                                        </li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-20 col-md-6 col-sm-12 mt-15">
                    <div class="wSelectCustom">
                        <?php
                        if ($this->input->get('direction_id')) {
                            $directionInfo = $this->direction_model->get_info($this->input->get('direction_id'));
                            if ($directionInfo) {
                                $directionName = $directionInfo->name;
                            }
                        }
                        ?>
                        <div class="select-custom">
                            <input class="importValue" type="hidden" name="direction_id" value="<?= $this->input->get('direction_id') ?>">
                            <div class="b importText text-white"><?= !empty($directionName) ? $directionName : '-- Chọn hướng --' ?></div>
                        </div>
                        <div class="listSelect ibg-3">
                            <ul>
                                <li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn hướng --</li>
                                <?php if (!empty($directionSearch)) : ?>
                                    <?php foreach ($directionSearch as $row) : ?>
                                        <li data-id="<?= $row->id ?>" data-type="default" class="itext-9 <?php /* $this->input->get('direction_id') == $row->id ? 'choose' : '' */ ?>" onclick="get_val_data(this)"><?= $row->name ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-20 col-md-6 col-sm-12 mt-15">
                    <div class="wSelectCustom">
                        <?php
                        if ($this->input->get('district_id')) {
                            $districtInfo = $this->district_model->get_info($this->input->get('district_id'));
                            if ($districtInfo) {
                                $districtName = $districtInfo->name;
                            }
                        }
                        ?>
                        <div class="select-custom">
                            <input class="importValue" type="hidden" name="district_id" value="<?= $this->input->get('district_id') ?>">
                            <div class="b importText text-white"><?= !empty($districtName) ? $districtName : '-- Chọn quận --' ?></div>
                        </div>
                        <div class="listSelect ibg-3">
                            <ul>
                                <li data-id="0" data-type="district" class="itext-9" onclick="get_val_data(this)">-- Chọn quận --</li>
                                <?php if (!empty($districtSearch)) : ?>
                                    <?php foreach ($districtSearch as $row) : ?>
                                        <li data-id="<?= $row->id ?>" data-type="district" class="itext-9 <?php /* $this->input->get('district_id') == $row->id ? 'choose' : '' */ ?>" onclick="get_val_data(this)"><?= $row->name ?></li>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-20 col-md-6 col-sm-12 mt-15">
                    <div class="wSelectCustom" id="wGetWard">
                        <?php
                        if ($this->input->get('ward_id')) {
                            $wardInfo = $this->ward_model->get_info($this->input->get('ward_id'));
                            if ($wardInfo) {
                                $wardName = $wardInfo->name;
                            }
                        }
                        ?>
                        <div class="select-custom">
                            <input class="importValue" type="hidden" name="ward_id" value="<?= $this->input->get('ward_id') ?>">
                            <div class="b importText text-white"><?= !empty($wardName) ? $wardName : '-- Chọn phường --' ?></div>
                        </div>
                        <div class="listSelect ibg-3">
                            <ul id="getWard">
                                <li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn phường --</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
    $("html, body").click(function(e) {
        // Cate select
        if ($(e.target).hasClass('lblCurrCate')) {
            $('#divCatagoryReOptions').css('display', 'block');
            return false;
        } else {
            $('#divCatagoryReOptions').css('display', 'none');
        }
        // Custom select
        if ($(e.target).hasClass('importText')) {
            return false;
        } else {
            $('.listSelect').css('display', 'none');
        }
    });
    // Cate select
    $('#divCatagoryReOptions>ul>li').click(function() {
        var id = $(this).attr('data-id');
        var name = $(this).text();
        $('#cateValue').val(id);
        $('#lblCurrCate').text(name);
    });
    // Custom select
    $('.importText').click(function() {
        $('.listSelect').css('display', 'none');
        var parent = $(this).closest('.wSelectCustom');
        parent.find('.listSelect').css('display', 'block');
    });

    function get_val_data(e) {
        var parent = $(e).closest('.wSelectCustom');
        var id = $(e).attr('data-id');
        var type = $(e).attr('data-type');
        var name = $(e).html();
        parent.find('.importValue').val(id);
        parent.find('.importText').html(name);
        if (type == 'district') {
            get_ward(id);
        }
    }
    // Load Ward
    function get_ward(district_id, $null = true) {
        if ($null == true) {
            $('#wGetWard .importValue').val('');
            $('#wGetWard .importText').text('-- Chọn phường --');
            $('#getWard').html('');
        }
        $.ajax({
            type: "POST",
            dataType: 'json',
            url: "<?= base_url('load-ward') ?>",
            data: {
                district_id: district_id
            },
            success: function(result) {
                if (result.status == 1) {
                    $('#getWard').html(result.html);
                } else if (result.status == 0) {
                    $('#getWard').html('<li data-id="0" data-type="default" class="itext-9" onclick="get_val_data(this)">-- Chọn phường --</li>');
                } else {
                    console.log(result);
                }
            }
        });
    }
    var district_id_trigger = "<?= $this->input->get('district_id') ?>";
    if (district_id_trigger > 0) {
        get_ward(district_id_trigger, false)
    }
    // Search
    $('.btn-search').click(function() {
        var catalog_id = $('.search input[name="catalog_id"]').val();
        var txtSearch = $('.search input[name="txtSearch"]').val();
        var price_id = $('.search input[name="price_id"]').val();
        var area_id = $('.search input[name="area_id"]').val();
        var direction_id = $('.search input[name="direction_id"]').val();
        var district_id = $('.search input[name="district_id"]').val();
        var ward_id = $('.search input[name="ward_id"]').val();

        var getString = new Object();
        getString.txtSearch = txtSearch;
        if (catalog_id.length > 0 && catalog_id > 0) {
            getString.catalog_id = catalog_id;
        }
        if (price_id.length > 0 && price_id > 0) {
            getString.price_id = price_id;
        }
        if (area_id.length > 0 && area_id > 0) {
            getString.area_id = area_id;
        }
        if (direction_id.length > 0 && direction_id > 0) {
            getString.direction_id = direction_id;
        }
        if (district_id.length > 0 && district_id > 0) {
            getString.district_id = district_id;
        }
        if (ward_id.length > 0 && ward_id > 0) {
            getString.ward_id = ward_id;
        }
        if (catalog_id.length > 0 && catalog_id != 0) {
            getString.type = 'cate';
            window.location.href = "<?= base_url() ?>" + catalog_id + '?' + $.param(getString)
        } else {
            getString.type = 'search';
            window.location.href = "<?= base_url('tim-kiem?') ?>" + $.param(getString)
        }
    })
    // Mobile
    $('.nav-search').click(function() {
        $('#real-search').addClass('open');
    });
    $('.close-search').click(function() {
        $('#real-search').removeClass('open');
    });
</script>