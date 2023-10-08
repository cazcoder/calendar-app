export default function useAjax() {

   async function ajax(method, url, dataObject){
      //alert('testing');
      try {
         return await axios({
            method: method,
            url: url,
            data: dataObject
          });
         
      } catch (error) {
         return error.response;
      }
   }

   return { ajax }

 }