app.service('UtilSvc',()=>{
    return {
        date:{
            toReadable:(date)=>{
                return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            },
            toTimeAgo:(date)=>{
                return moment(date).fromNow();
            }
        }
    }
});
