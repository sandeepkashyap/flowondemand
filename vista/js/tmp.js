{
                    // Contacts icon view.
                    xtype: "dataview",
                    id: "dvContactsIconView",
                    store: application.imagesStore,
                    tpl: new Ext.XTemplate("<tpl for=\".\">", "<div class=\"thumb-wrap\">", "<div class=\"thumb\">" +
                    "<img src=\"thumbnails/{thumbnail}.jpg\"></div>", "</div></tpl>", "<div class=\"x-clear\"></div>"),
                    singleSelect: true,
                    overClass: "x-view-over",
                    itemSelector: "div.thumb-wrap"
                }