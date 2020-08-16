

// const app = new Vue({
//     el: '#app',

//     data:{
  
//     	newItem:{
//            name:'', 
//            telephone:'',
//            _token:$('input[name="_token"]').val()
               
//       },
//       hasError:true,
//     },

//       methods:{
//       	createItem: function(){
         
//           var input = this.newItem;

//            if(input.name==='' || input.telephone===''){
//             this.hasError = false;
//            }
        
//            else{
         
//              this.hasError = true;
//               axios({
//               method: 'post',
//               url: 'storedata',
//               data: this.newItem

//             })
//             .then(function (response) {
//                 console.log(response);
//               })
//               .catch(function (error) {
//                 console.log(error);
//             });

        
//            }
//       	}
//       }
    
// });
// Vue.use(window.vuelidate.default);
// Vue.use(window.VeeValidate);

Vue.use(VeeValidate);


const app = new Vue({
    el: '#app',

    data:{
        
     // this object(usertable) is accepting an array
      usertable:[],
      //newitem this is an object with its properties 
      newItem:{
           id:'',
           name:'', 
           email:'',
           telephone:'',
           password:'',
           _token:$('input[name="_token"]').val()

      
      },         

      hasError:true,
      },
      

      methods:{
         
         validateallforms: function(){
          if (this.fields) {
            return  object.keys(this.fields).forEach(function(key){
              if (this.fields[key].invalid && this.fields[key].untouched) {
                this.fields[key].touched = true;
                return false;
              }
            })
          } else{
            return false;
          }
         },
        compareusername: function(name,email){ 
        
           axios.get('compareusername',{params:{name:name,email:email}}).then(response=>{
                  if (response.data.status ==='exist') {
                    alert('Name already exist ');
                  }else if(response.data.status ==='notsaved'){
                    alert('Data not saved');
                    // return false;
                  }else{
                    alert('saved');
                    var me = this
                    me.newItem.id=response.data.id
                    // console.log(response.data.id);
                    me.usertable.unshift(me.newItem);
                   console.log($ref.myform)
                  }
           })
           .catch(err=>{
            console.log(err);
           })
        },
        createItem: function(){
           var me = this
        
          var input = this.newItem;


          if(input.name===''||input.email===''||input.telephone===''||input.password===''){
            this.hasError = false;
         }
        else {
             this.compareusername(input.name,input.email)
             this.hasError = true;
            //   axios({
            //   method: 'post',
            //   url: 'storedata',
            //   data: this.newItem

            // })
            // .then(function (response) {
            //     console.log(response);
            //    me.newItem.id=response.data.id
            //    me.usertable.unshift(me.newItem);
            //     //  if(me.newItem.name === response.data.name ){
            //     //   alert("LOL you are not qualified")
            //     // }
              
            //   //unshift ... this is used to push the data to the table direct
            //    //we can also use push or shift. the push moves the data down to ur table, unshift moves it up
            //   })
            //   .catch(function (error) {
            //     console.log(error);
            // });


             }
           
        },

        getuserdata: function(){
           // this function is actualy geting data from the data 
          //you do var me = this bcos when you want to access or retrive or store data into a variable above the (scoping)
          var me  = this
              axios({
              method: 'get',
              url: 'getuserdata',

            })
            .then(function (response) {
                console.log(response);
                //so hr the responds helps us to get data from the url and place it in response
               me.usertable = response.data;
                // response.data   ..this is where the data is actualy stores after fetching data with axios
              })
              .catch(function (error) {
                console.log(error);
            });
           
        }
      }
    
});
app.getuserdata();

//use this method when you are using vuelidate

  //    methods:{

  //    // fire($v){
  //    //     console.log($v);
  //    // },

  //    status(validation) {
  //      return {
  //      error: validation.$error,
  //      dirty: validation.$dirty
  //    }

  //    }

  //    },
 
  //     validations: {
  //      name: {
  //      required:window.validators.required,
  //      minLength: window.validators.minLength(4)


  //   }
   
  // }
    
