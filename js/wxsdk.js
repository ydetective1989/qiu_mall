wx.ready(function () {
    wx.hideAllNonBaseMenuItem();
});

function getScanCode(obid){
    wx.scanQRCode({
        needResult: 1,
        scanType: ["barCode"],
        success: function (res) {
            var code = res.resultStr;
            var strs = code.split(",");
            $("#"+obid).attr("value",strs[1]);
        }
    });
}

function getMap(lng,lat,name,address,url)
{
    wx.openLocation({
        latitude: lat,
        longitude: lng,
        name: name,
        address: address,
        scale: 14,
        infoUrl: 'https://fuwu.shui.cn'
    });
}

function getPoint()
{
    wx.getLocation({
        success: function (res) {
            alert(JSON.stringify(res));
        },
        cancel: function (res) {
            alert('NULL');
        }
    });
}