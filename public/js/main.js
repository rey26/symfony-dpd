$( document ).ready(function() {
    getAllBranches();
    $(document).on("click", "a.link", function(){
        getBranchDetail($(this).data("id"));
    });
    $(document).on("click", "#back", function(){
        getAllBranches();
    });
});

function getAllBranches(){
    $.get({
        url: "/api/branches/all",
        success: function(result){
            viewAllBranches(result);
        },
        failure: function(data){
            console.log("All branches error" + data);
        }
    });
}

function viewAllBranches(branches){
    var html = '<ul class="list-group">';
    branches.forEach(function(branch){
        html += '<li class="list-group-item"><a href="javascript:void(0);" data-id="' + branch.internalId + '" class="link">' + branch.internalId + ' ' + branch.internalName + '</li>';
    })
    html += '</ul>';

    $("#root").html(html);
}

function getBranchDetail(id){
    $.get({
        url: "/api/branches/detail/" + id,
        success: function(result){
            viewBranchDetail(result);
        },
        failure: function(data){
            console.log("Detail error" + data);
        }
    })
}

function viewBranchDetail(branch){
    var html = '<h4>' + branch.internalName + '</h4>';
    html += branch.internalId.length > 0 ? '<p>Interné ID: ' + branch.internalId + '</p>' : '';
    html += (branch.location.length > 0) ? '<p>Súradnice: ' + branch.location + '</p>' : '';
    if(branch.businessHours.length > 0){
        var businessHoursHtml = '<p>Otváracie hodiny:<br>';
        businessHoursHtml += '<table class="table">';
        branch.businessHours.forEach(function(day){
            businessHoursHtml += '<tr>';
            businessHoursHtml += '<td>' + day.dayOfWeek + '</td>';
            businessHoursHtml += '<td>' + day.businessHour + '</td>';
            businessHoursHtml += '</tr>';
        });
        businessHoursHtml += '</table></p>';
        html += businessHoursHtml;
    }
    html += branch.address.length > 0 ? '<p>Adresa: ' + branch.address + '</p>' : '';
    html += branch.phoneNumber.length > 0 ? '<p>Telefón: ' + branch.phoneNumber + '</p>' : '';
    html += branch.email.length > 0 ? '<p>Email: ' + branch.email + '</p>' : '';
    html += '<button type="button" class="btn btn-primary" id="back">Späť</button>';
    $("#root").html(html);
}
