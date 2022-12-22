import React from "react";
// import ReactDom from "react-dom";
import { createRoot } from 'react-dom/client'
import Login from './Auth/Login';

export default function App(){

    return(
      <>
      <Login />
      </>
 );

}    

if(document.getElementById('app')){
    createRoot(document.getElementById('app')).render(
    <App />
    ); 

}
