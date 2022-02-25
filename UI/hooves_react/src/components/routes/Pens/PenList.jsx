import React from 'react'
import { useState, useEffect } from 'react';

function PenList() {
    const [AllCows, setAllCows] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/pens?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setAllCows(result)
            })
    }, []);
    return(
        <div>List</div>
    )
}

export default PenList