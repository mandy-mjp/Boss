@extends('layout_pop')
@section('content')
    <style>
        .edit-label {
            width: 105px;
            display: inline-block;
        }

        .img-des, .important-des {
            margin-left: 105px;
        }

        .important-des {
            position: relative;
            top: -18px;
        }

        .category-box {
            display: inline-block;
            width: 80px;
        }

        .goods-guide {
            border: 1px solid #ccc;
            padding: 10px;
        }

        .goods-edit-input {
            width: 220px !important;
        }

        /*文件上传样式重写*/

        .uploadify {
            position: relative;
            left: 109px;
            margin-top: 10px;
            border: 1px solid #c0c0c0;
        }

        .uploadify-queue {
            display: none;
        }

        .uploadify-button-text {
            line-height: 45px;
            font-size: 50px;
            text-align: center;
            display: inline-block;
            width: 50px;
            height: 50px;
            color: #c0c0c0;
        }

        .img-del {
            display: inline-block;
            width: 13px;
            height: 13px;
            position: relative;
            top: -41px;
            left: -13px;
            cursor: pointer;
            background: url("{{asset('images/acrossTab-close.png')}}") -91px -13px;
        }

        .images-div {
            display: inline-block;
        }

        .des-upload > .uploadify {
            left: 0 !important;
        }
        .desc-del {
            display: inline-block;
            width: 19px;
            height: 19px;
            position: relative;
            top: -440px;
            left: 183px;
            cursor: pointer;
            background: url("{{asset('images/icon_error_s.png')}}");
        }
    </style>

    <div class="row lh-30 f-20 bg-1 pd-5">商品编辑</div>
    <div class="row ml-30">
        <form action="" method="post">
            <!--基本信息-->
            <div class="row">
                <div class="row">
                    <p class="mt-10 f-16">基本信息</p>
                    <div class="line"></div>
                </div>
                <div class="col-md-10 mt-10">
                    <div class="col-md-4">
                        <span class="text-r edit-label">所属供应商：</span> <span>杨洋</span>
                    </div>
                    <div class="col-md-4">
                        <span class="text-r edit-label">保证金：</span> <span>￥2000.00</span>
                    </div>
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">店铺名称：</span> <span> 九江土特产店</span>
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">* 产品分类：</span>
                    <select name="category_id">
                        @foreach($goods->conf_categories as $category)
                            <option value="{{$category->id}}"
                                    @if($category->id == $goods->category_id) selected @endif>{{$category->name}}</option>

                        @endforeach
                    </select>
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">* 运营分类：</span>
                    @foreach($goods->conf_categories as $conf_category)
                        <span class="category-box"><input type="checkbox"
                                                          @if(in_array($conf_category->id,$goods->goods_category)) checked
                                                          @endif name="goods_category"
                                                          value="{{$conf_category->id}}">{{$conf_category->name}}</span>

                    @endforeach
                    (可多选)
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">* 商品名称：</span>
                    <input type="text" class="input-text goods-edit-input" name="title" value="{{$goods->title}}"
                           disabled/>
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">* 所属分馆：</span>
                    <select name="paivion">
                        @foreach($goods->pavilions as $pavilion)
                            <option value="{{$pavilion->id}}"
                                    @if($pavilion->id == $goods->pavilion) selected @endif >{{$pavilion->name}}</option>
                        @endforeach
                    </select>
                    (可修改)
                </div>
                <div class="col-md-10 mt-10">

                    <span class="text-r edit-label">* 封面图：</span>
                    <img src="http://{{env('IMAGE_DOMAIN')}}/{{$goods->cover}}" class="cover-upload" alt="" width="180"
                         height="120">
                    <input type="hidden" name="cover" class="cover"/>
                    <input type="file" id="cover-upload"/>
                    <p class="img-des">建议尺寸：640*400像素。封面图将用于商品列表等.</p>
                </div>

                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label images-label">* 轮播图：</span>
                    @foreach($goods->images as $image)
                        <div class="images-div">
                            <img src="http://7xs9e9.com1.z0.glb.clouddn.com/{{$image->name}}" alt="" width="100"
                                 height="100"><span class="img-del"></span>
                            <input type="hidden" name="images[]" value="{{$image->name}}">
                        </div>
                    @endforeach
                    <input type="file" id="images-file-upload"/>
                    <p class="ml-10 img-des">建议尺寸：640*640像素，请添加5~9张图。</p>
                </div>
                <div class="col-md-10 mt-10">
                    <span class="text-r edit-label">* 重要提示：</span>
                    <div>
                        <textarea name="important_tips" class="important-des text-l" cols="60"
                                  rows="5">{{$goods->ext->important_tips}}</textarea>
                    </div>
                </div>
            </div>
            <!--商品规格-->
            <div class="row">
                <div class="col-md-12">
                    <p class="mt-10 f-16">商品规格</p>
                    <div class="line"></div>
                </div>
                <div class="col-md-10 goods-guide mt-10">
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 规格：</span>
                            <input type="text" name="name[]" class="input-text goods-edit-input" value=""/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">包装件数：</span>
                            <input type="text" name="pack_num[]" class="input-text goods-edit-input" value=""/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 重量：</span>
                            <input type="text" name="weight[]" class="input-text goods-edit-input"/> KG

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 净含量：</span>
                            <input type="text" name="weight_net[]" class="input-text goods-edit-input"/> KG
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">长：</span>
                            <input type="text" name="long[]" class="input-text goods-edit-input"/> M

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">宽：</span>
                            <input type="text" name="wide[]" class="input-text goods-edit-input"/> M
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">高：</span>
                            <input type="text" name="height[]" class="input-text goods-edit-input"/> M

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 供应价：</span>
                            <input type="text" name="price_buying[]" class="input-text goods-edit-input"/> 元
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 库存：</span>
                            <input type="text" name="num[]" class="input-text goods-edit-input"/> 件

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 零售价：</span>
                            <input type="text" name="price[]" class="input-text goods-edit-input"/> 元
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">平台服务费：</span>
                            <input type="text" name="platform_fee[]" class="input-text goods-edit-input"/> 元

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">利润：</span>
                            <input type="text" name="" class="input-text goods-edit-input" disabled/> 元
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">运费：</span>
                            <input type="radio" name="express_fee_mode[]"/>全国包邮

                        </div>
                        <div class="col-md-5">
                            <input type="checkbox" name=""/>是否允许自提
                        </div>
                    </div>

                </div>
            </div>
            <!--基本属性-->
            <div class="row">
                <div class="col-md-12">
                    <p class="mt-10 f-16">基本属性</p>
                    <div class="line"></div>
                </div>

                <div class="col-md-10 goods-guide mt-10">
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 发货地：</span>
                            <input type="text" name="send_out_address" class="input-text goods-edit-input" value=""/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 产地：</span>
                            <input type="text" name="product_area" class="input-text goods-edit-input" value=""/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 保质期：</span>
                            <input type="text" name="shelf_life" class="input-text goods-edit-input"/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 贮藏：</span>
                            <input type="text" name="store" class="input-text goods-edit-input"/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 包装：</span>
                            <input type="text" name="pack" class="input-text goods-edit-input"/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 快递说明：</span>
                            <input type="text" name="express_desc" class="input-text goods-edit-input"/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 发货说明：</span>
                            <input type="text" name="send_out_desc" class="input-text goods-edit-input"/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">* 售后说明：</span>
                            <input type="text" name="sold_desc" class="input-text goods-edit-input"/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">食品添加剂：</span>
                            <input type="text" name="food_addiitive" class="input-text goods-edit-input"/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">生产许可证：</span>
                            <input type="text" name="product_license" class="input-text goods-edit-input"/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">等级：</span>
                            <input type="text" name="level" class="input-text goods-edit-input"/>

                        </div>
                        <div class="col-md-5">
                            <span class="text-r edit-label">制造产商/公司：</span>
                            <input type="text" name="company" class="input-text goods-edit-input" disabled/>
                        </div>
                    </div>
                    <div class="col-md-10 mt-10">
                        <div class="col-md-5">
                            <span class="text-r edit-label">配料表：</span>
                            <textarea name="" class="food_burden" cols="60" rows="6"></textarea>

                        </div>
                        <div class="col-md-5">
                            <div class="row">
                                <span class="text-r edit-label">经销商：</span>
                                <input type="text" name="dealer" class="input-text goods-edit-input"/>
                            </div>
                            <div class="row mt-10">
                                <span class="text-r edit-label">地址：</span>
                                <input type="text" name="address" class="input-text goods-edit-input"/>
                            </div>
                            <div class="row mt-10">
                                <span class="text-r edit-label">特别说明：</span>
                                <input type="text" name="remark" class="input-text goods-edit-input"/>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--赠品信息-->

            <div class="row">
                <div class="col-md-12">
                    <p class="mt-10 f-16">赠品信息</p>
                    <div class="line"></div>
                </div>
                @foreach($goods->gift as $gift)
                <div class="col-md-10 mt-10">
                    <div class="col-md-10 mt-10">
                        <div class="col-md-1">
                            id
                        </div>
                        <div class="col-md-1">
                            <img src="" alt="" width="80" height="80"/>
                        </div>
                        <div class="col-md-4">
                            商品名称商品名称商品名称...
                        </div>
                        <div class="col-md-2">
                            规格：5斤装
                        </div>
                        <div class="col-md-2">
                            库存：200件
                        </div>

                    </div>
                    <input type="hidden" name="gift[]" value="{{$gift->gift_id}}" />
                </div>
                @endforeach
            </div>

            <!--商品详情-->
            <div class="row">
                <div class="col-md-12">
                    <p class="mt-10 f-16">商品详情</p>
                    <div class="line"></div>
                </div>

                <div class="col-md-10 mt-10">
                    <div class="col-md-10 mt-10">
                        @foreach($goods->desc as $desc)
                            <div class="row des-upload">
                                <img src="http://{{env('IMAGE_DOMAIN')}}/{{$desc->name}}" class="des-img-{{$desc->id}}" width="200"
                                     height="200"/>
                                <input type="hidden" name="desc_name[]" class="desc-{{$desc->id}}" value="{{$desc->name}}" />
                                <input type="file" id="des-upload-{{$desc->id}}"/>
                                <div class="row">
                            <textarea name="description[]" class="mt-10" cols="70"
                                      rows="10">{{$desc->description}}</textarea>
                                </div>
                                <span class="desc-del-test"></span>
                            </div>

                        @endforeach


                    </div>
                </div>
            </div>
            <div class="col-md-8 text-c pd-20">
                <button type="button" class="btn btn-danger mr-30">返回</button>
                <button type="submit" class="btn btn-success">保存并更新</button>
            </div>
        </form>
    </div>
    </div>
    <script src="{{ asset('lib/uploadify/jquery.uploadify.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript">
        <?php $timestamp = time();?>
        $(function () {
            //轮播图上传
            $('#images-file-upload').uploadify({
                'formData': {
                    'timestamp': '<?php echo $timestamp;?>',
                    'token': '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf': '{{ asset('lib/uploadify/uploadify.swf') }}',
                'uploader': '{{ url('/goods/upload') }}',
                'buttonText': '+',
                'fileTypeDesc': 'filetypedesc',
                'fileTypeExts': '*.gif; *.jpg; *.png',
                'height': 50,
                'width': 50,
                'onUploadSuccess': function (file, data, response) {
                    data = JSON.parse(data);
                    var images_div = '<div class="images-div">' +
                        '<img src="http://7xs9e9.com1.z0.glb.clouddn.com/' + data.img + '" alt="" width="100" height="100"><span class="img-del"></span>' +
                        '<input type="hidden" name="images[]" value="' + data.img + '"></div>';
                    $('.images-label').after(images_div);
                    //轮播图删除
                    images_remove();
                }
            });
            //封面图上传
            $('#cover-upload').uploadify({
                'formData': {
                    'timestamp': '<?php echo $timestamp;?>',
                    'token': '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf': '{{ asset('lib/uploadify/uploadify.swf') }}',
                'uploader': '{{ url('/goods/upload') }}',
                'buttonText': '+',
                'fileTypeDesc': 'filetypedesc',
                'fileTypeExts': '*.gif; *.jpg; *.png',
                'height': 50,
                'width': 50,
                'onUploadSuccess': function (file, data, response) {
                    data = JSON.parse(data);
                    $('.cover-upload').attr('src', 'http://7xs9e9.com1.z0.glb.clouddn.com/' + data.img);
                    $('.cover').val(data.img);
                }
            });

            @foreach($goods->desc as $desc)
            //详情图上传
            $('#des-upload-{{$desc->id}}').uploadify({
                'formData': {
                    'timestamp': '<?php echo $timestamp;?>',
                    'token': '<?php echo md5('unique_salt' . $timestamp);?>'
                },
                'swf': '{{ asset('lib/uploadify/uploadify.swf') }}',
                'uploader': '{{ url('/goods/upload') }}',
                'buttonText': '+',
                'fileTypeDesc': 'filetypedesc',
                'fileTypeExts': '*.gif; *.jpg; *.png',
                'height': 50,
                'width': 50,
                'onUploadSuccess': function (file, data, response) {
                    data = JSON.parse(data);
                    $('.des-img-{{$desc->id}}').attr('src', 'http://7xs9e9.com1.z0.glb.clouddn.com/' + data.img);
                }
            });
            @endforeach

            //轮播图删除
            function images_remove() {
                $('.img-del').bind('click', function () {
                    $(this).parent().remove();
                })
            }
            function desc_remove() {
                $('.desc-del').bind('click', function () {
                    $(this).parent().remove();
                })
            }
            images_remove();
            desc_remove();

        });

    </script>
@stop
