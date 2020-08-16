Vue.use(VeeValidate);


var item = new Vue({
  el: '#item',
  data:{
  	itemtable:[],
    updating:false,
    flag:'add',


  	formdata:{
  		id:'',
  		tblproductname:'',
  		tblproductcategory_id:'',
  		tblproductqty:'',
  		threshold_quantity:'',
  		tblproductpcp:'',
  		tblproductpsp:'',
  		
  	},
  	 hasError:true,
  },
  methods:{
  	 createItem: function(){
      var _self=this;
      this.formdata.flag = this.flag;
      console.log(this.formdata);
     // return
     axios.post('saveproduct',this.formdata).then((res)=>{
     	$('#myForms')[0].reset();
 
     	if(res.data.status==='success'){
     		alert('item added successfully');
        _self.getitemdata();
     		  
     	}else if(res.data.status==='exists'){
     	  alert('item exists');
     	}else if (res.data.status==='update') {
         alert('item updated successfully')
      }
     	else {
     		alert('item not added');
     	}
     	
     }).catch(function(err){

     });
  	// body...
  },
  
        getitemdata: function(){
           // this function is actualy geting data from the data 
          //you do var me = this bcos when you want to access or retrive or store data into a variable above the (scoping)
          var me  = this
              axios({
              method: 'get',
              url: 'getitemdata',

            })
            .then(function (response) {
                 console.log(response.data);
                //so hr the responds helps us to get data from the url and place it in response
               me.itemtable = response.data.itemdata;
                // response.data   ..this is where the data is actualy stores after fetching data with axios
              })
              .catch(function (error) {
                console.log(error);
            });
           
        },
          deleteitem: function(id,index){
            if(confirm('Are you sure you want to delete')){
           var me  = this
           axios.get('deleteitem',{params:{id:id}}).then(function (response){
                 
                if (response.data.status==='success') {
                  alert('item deleted successfully');
                  me.itemtable.splice(index,1);

                }
              }).catch(function (error){
                console.log(error);
            });
          }
        },
        updateitem: function(id, index){
          var me = this;
          me.updating = true;
          me.flag = 'update';
        
          console.log(me.itemtable[index]);
            
              me.formdata = me.itemtable[index];
          
        }, 

        // updateitem: function(id, index){

        //      axios.get('updateitem',{params:{id:id}}).then(function (response){
                 
        //         if (response.data.status==='success') {
        //           alert('item updated successfully');
                 

        //         }
        //       }).catch(function (error){
        //         console.log(error);
        //     });
        // },

  },
  watch:{
    updating:function(val){
      console.log(val);
      if(val){
        $('#myForms')[0].reset();
      }
    }
  }
  
});
item.getitemdata();
//item.createItem();
