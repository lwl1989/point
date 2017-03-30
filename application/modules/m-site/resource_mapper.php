<?php
/**
 * 菜单资源对应
 */
return [
    'channels' => [
        // 'users'    => '用户管理',
        'system' => '系统设置',
        'contents' => '内容管理',
        'marketing' => '营销管理',
        // 'jifen'=>'积分商城'
//        'data' => '数据报表',
    ],
    'menus' => [
        //模块
        //系统设置
        'system' => [
            //二级菜单
            '站点设置' => [
                //三级菜单
                '基本信息' => [
                    'url' => 'm-site/sites_config/edit',
                    'resource' => 'm-site/sites_config',
                    'action' => ['edit', 'update'],
                ],

            ],

            '基础数据' => [
                '城市区域' => [
                    'url' => 'm-site/zones/index',
                    'resource' => 'm-site/zones',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '添加、编辑',
                            'action' => ['save'],
                        ],
                        [
                            'title' => '删除',
                            'action' => ['del'],
                        ],
                        [
                            'resource' => 'm-site/business_circles',
                            'title' => '商圈管理(列表、添加、编辑、删除)',
                            'action' => ['index', 'save', 'del'],
                        ],
                        [
                            'resource' => 'm-site/business_circles',
                            'title' => '更新商圈文件缓存',
                            'action' => ['refresh_cache'],
                        ],
                    ],
                ],
                '分类导航' => [
                    'url' => 'm-site/classifies/index',
                    'resource' => 'm-site/classifies',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '添加、编辑',
                            'action' => ['save'],
                        ],
                        [
                            'title' => '删除',
                            'action' => ['del'],
                        ],
                        [
                            'resource' => 'm-site/classifies',
                            'title' => '更新导航缓存',
                            'action' => ['refresh_cache'],
                        ],
                    ],
                ],
            ],
            '管理员设置' => [
                '角色设置' => [
                    'url' => 'm-site/setting/resource_acl/index',
                    'resource' => 'm-site/setting/resource_acl',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '添加、编辑',
                            'action' => ['save'],
                        ],
                        [
                            'title' => '删除',
                            'action' => ['del'],
                        ],
                        [
                            'title' => '角色权限',
                            'action' => ['role_resources'],
                        ],
                    ],
                ],
                '人员管理' => [
                    'url' => 'm-site/setting/site_admin/index',
                    'resource' => 'm-site/setting/site_admin',
                    'action' => ['index'],
                ],
            ],
        ],
        //内容管理
        'contents' => [
            '用户'    =>  [
                '用户列表'  =>[
                    'url'   =>  'm-site/user/index',
                    'resource'  =>  'm-site/user',
                    'action'    =>  ['index'],

                ]
            ],
             '文章'    =>  [
                  '文章列表'  =>[
                       'url'   =>  'm-site/articles/index',
                       'resource'  =>  'm-site/articles',
                       'action'    =>  ['index'],
                       'groups' => [
                            [
                                 'title' => '添加',
                                 'action' => ['add', 'save'],
                            ],
                            [
                                 'title' => '编辑',
                                 'action' => ['edit', 'save'],
                            ],
                       ]
                  ],
                  '新增文章' => [
                       'url' => 'm-site/articles/add',
                       'resource' => 'm-site/companies',
                       'action' => ['add', 'save'],
                  ]
             ],
             '文档'    =>  [
                  '文档列表'  =>[
                       'url'   =>  'm-site/document/index',
                       'resource'  =>  'm-site/document',
                       'action'    =>  ['index'],
                       'groups' => [
                            [
                                 'title' => '添加',
                                 'action' => ['add', 'save'],
                            ],
                            [
                                 'title' => '编辑',
                                 'action' => ['edit', 'save'],
                            ],
                           [
                               'title'  =>  '生成',
                               'action' =>  ['create']
                           ]
                       ],
                  ]
             ],
            //二级菜单
            '加盟商家' => [
                //三级菜单
                '商家列表' => [
                    'url' => 'm-site/companies/index',
                    'resource' => 'm-site/companies',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '添加',
                            'action' => ['add', 'save'],
                        ],
                        [
                            'title' => '编辑(基本信息、文本信息)',
                            'action' => ['edit', 'save', 'edit_text', 'do_edit_text'],
                        ],
                        [
                            'title' => '设置商圈',
                            'action' => ['set_circle'],
                        ],
                        [
                            'title' => '属性设置',
                            'action' => ['attrs', 'attrs_save'],
                        ],
                        [
                            'title' => 'banner设置',
                            'action' => ['banners', 'add_banner', 'banners_edit', 'do_banners_edit', 'banner_del'],
                        ],
                        [
                            'title' => '删除',
                            'action' => ['del'],
                        ],
                        [
                            'resource' => 'm-site/company_images',
                            'title' => '图片管理',
                            'action' => ['index', 'add', 'upload_single_pic', 'muti_edit', 'do_muti_edit', 'del'],
                        ],

                    ],
                ],
                /*'新增商家' => [
                    'url' => 'm-site/companies/add',
                    'resource' => 'm-site/companies',
                    'action' => ['add', 'save'],
                ],*/
                '评论列表' => [
                    'url'=>'m-site/company_comments/index',
                    'resource'=>'m-site/company_comments/index',
                    'action'=>['edit','save']
                ],
                '提现申请' => [
                        'url'=>'m-site/withdraw_deposit/index',
                        'resource'=>'m-site/withdraw_deposit/index',
                        'action'=>['edit','save']
                ],
            ],

        ],
        'marketing' => [
            '页面管理' => [
                '首页推荐' => [
                    'url' => 'm-site/marketing/page_index/index',
                    'resource' => 'm-site/marketing/page_index',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '店铺周推荐',
                            'action' => ['weekly_recommend', 'add_ad', 'edit_ad'],
                        ],
                        [
                            'title' => '组推荐',
                            'action' => ['group_recommend', 'add_ad', 'edit_ad'],
                        ],
                        [
                            'title' => '缓存更新',
                            'action' => ['generate_config'],
                        ],
                    ],
                ],
                 '增加推荐' => [
                      'url' => 'm-site/marketing/page_index/set_recommend',
                      'resource' => 'm-site/marketing/page_index',
                      'action' => ['add','save'],
                 ],
            ],
            '微信' => [
                '关键字列表' => [
                    'url' => 'm-site/wechat_key/index',
                    'resource' => 'm-site/wechat_key/',
                    'action' => ['index'],
                    'groups' => [
                        [
                            'title' => '添加关键字',
                            'action' => [ 'so_save'],
                        ],
                    ],
                ],
                '公众号设置' => [
                    'url' => 'm-site/wechat_key/set',
                    'resource' => 'm-site/wechat_key/',
                    'action' => ['save'],
                ],
                '自定义菜单' => [
                    'url' => 'm-site/wechat_key/set_menu',
                    'resource' => 'm-site/wechat_key/',
                    'action' => ['add','save'],
                ],
            ],
        ],
       


    ],
];