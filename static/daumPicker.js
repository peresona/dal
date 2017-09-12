// 제작 : 이윤규 2017-03-23

// 마커 움직인 후 검색
function moveAndSearch(){
    var tmp_lat = document.getElementById('addr_lat').value;
    var tmp_lng = document.getElementById('addr_long').value;
    $.ajax({
        type: "POST",
        dataType: 'jsonp',
        url: "https://apis.daum.net/local/geo/coord2addr",
        data: {
             apikey: '6b72c4c6de26e90f11c0e92b8f79b97a',
             latitude: tmp_lat,
             longitude: tmp_lng,
             output: 'json'
        },
        success: function(response) {
            //console.log(response);
                if(response.fullName) {
                	$('#address').val(response.fullName);
                	$('#address_detail').val('');
                }
        }
    });

}

var mapContainer = document.getElementById('grp_map'), // 지도를 표시할 div 
mapOption = { 
    center: new daum.maps.LatLng((default_lat.length > 0)?default_lat:'37.49789009883285', (default_long.length > 0)?default_long:'127.02757669561151'), // 지도의 중심좌표
    level: 3 // 지도의 확대 레벨
};
var map = new daum.maps.Map(mapContainer, mapOption); // 지도를 생성합니다
// 마커가 표시될 위치입니다 
var markerPosition = new daum.maps.LatLng((default_lat.length > 0)?default_lat:'37.49789009883285', (default_long.length > 0)?default_long:'127.02757669561151'); 

// 마커를 생성합니다
var marker = new daum.maps.Marker({
    position: markerPosition
});

// 아래와 같이 옵션을 입력하지 않아도 된다
var zoomControl = new daum.maps.ZoomControl();
// 지도 오른쪽에 줌 컨트롤이 표시되도록 지도에 컨트롤을 추가한다.
map.addControl(zoomControl, daum.maps.ControlPosition.RIGHT);


// 마커가 지도 위에 표시되도록 설정합니다
marker.setMap(map);
daum.maps.event.addListener(marker, 'dragend', function() {
    var tmp = marker.getPosition();
    $('#addr_lat').val(tmp.hb);
    $('#addr_long').val(tmp.gb);
    moveAndSearch();
    map.setCenter(new daum.maps.LatLng(tmp.hb, tmp.gb));
});
// 마커가 드래그 가능하도록 설정합니다 
marker.setDraggable(true); 

function search_move(){
    var keyword = document.getElementById('place_keyword').value;
    $.ajax({
        type: "POST",
        dataType: 'jsonp',
        url: "https://apis.daum.net/local/geo/addr2coord",
        data: {
             apikey: '6b72c4c6de26e90f11c0e92b8f79b97a',
             q: keyword,
             output: 'json'
        },
        success: function(response) {
            var first_item = response.channel.item[0];
            if(first_item){
                console.log(first_item);
                $('#address').val(response.channel.item[0].title);
                if(first_item.buildingAddress) $('#address_detail').val(first_item.buildingAddress);
                	else $('#address_detail').val('');
                $('#addr_lat').val(first_item.lat);
                $('#addr_long').val(first_item.lng);
                map.setCenter(new daum.maps.LatLng(first_item.lat, first_item.lng));
                marker.setPosition(new daum.maps.LatLng(first_item.lat, first_item.lng));
            }else{
                alert('검색된 주소가 없습니다.');
            }
        }
    });
}
