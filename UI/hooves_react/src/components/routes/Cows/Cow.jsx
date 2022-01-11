import { useParams, Link } from 'react-router-dom';
import { useState, useEffect} from 'react';

import DisplayItems from '../../DisplayItems';
import Back from '../../Back'



function Cow() {
    
    const { ID } = useParams();
    const [Cow, setCow] = useState({});
    useEffect(() => {
      fetch(process.env.REACT_APP_API_URL+'/cattle/'+ID+'?token='+localStorage.getItem('Token'))
            .then(response => response.json())
            .then(result => {
              setCow(result)
              
            })
    }, [ID]);

    return (
        <div>
            <Back link='/cows' />
            {Cow.Data &&
            <>
                <Link to={`/cows/update/${ID}`}>
                    <button className='btn'>Edit</button>
                </Link>
                <Link to={`/cows/delete/${ID}`}>
                    <button className='btn delete-btn'>Delete</button>
                </Link>
                <DisplayItems data={Cow}/>
            </>
            }        
        </div>
    )
}

export default Cow
