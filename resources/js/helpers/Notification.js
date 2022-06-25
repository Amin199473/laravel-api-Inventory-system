export default {
    success() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Done!',
            timeout: 1000,
        }).show();
    },
    alert() {
        new Noty({
            type: 'alert',
            layout: 'topRight',
            text: 'Are You Sure!',
            timeout: 1000,
        }).show();
    },
    error() {
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Something Went Wrong!',
            timeout: 1000,
        }).show();
    },
    warning() {
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Opps Wrong!',
            timeout: 1000,
        }).show();
    },
    image_validation() {
        new Noty({
            type: 'error',
            layout: 'topRight',
            text: 'Upload Image less that 1MB!',
            timeout: 1000,
        }).show();
    },
    SalaryExist() {
        new Noty({
            type: 'warning',
            layout: 'topRight',
            text: 'Salary Already Exist!',
            timeout: 1000,
        }).show();
    },
    cartSuccess() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Add To Cart.',
            timeout: 1000,
        }).show();
    },
    cartRemove() {
        new Noty({
            type: 'success',
            layout: 'topRight',
            text: 'Successfully Remove From Cart.',
            timeout: 1000,
        }).show();
    },

}
