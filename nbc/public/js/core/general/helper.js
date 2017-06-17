function identifyTitle () {

}


function identifyStatus (status) {
    var result;
    switch (parseInt(status)) {
        case 1 :
            result = "draft";
            break;
        case 2 :
            result = "published";
            break;
            break;
        case 5 :
            result = "in_progress";
            break;
        case 6 :
            result = "closed";
            break;
    }
    return result;
}

function identifyType (status) {
    var result;
    switch (parseInt(status)) {
        case 1 :
            result = "New Project Created";
            break;
        case 2 :
            result = "Project Update";
            break;
        case 3 :
            result = "New Contract";
            break;
        case 4 :
            result = "Contract Approval";
        case 11 :
            result = "New Applicant";
            break;
    }
    return result;
}
