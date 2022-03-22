import { useState } from "react"
import { Link } from "react-router-dom"

function Search() {
    const [ Search, setSearch ] = useState(false)

    const searchCatch =  async (e) =>{
        let val = e.target.value
        if(val && val !== ' ' && val !== '%' && val !== '#'){
            fetch(process.env.REACT_APP_API_URL+'/cattle/search/'+val+'?limit=10&token='+localStorage.getItem('Token'))
              .then(response => response.json())
              .then(result => {
                setSearch(result)
            })
        }else{
            setSearch(null) 
        }
    }
    const SearchOut = (props) => {
        const { data } = props
        return(
            <div className="searchItems">
                {data.map((item, key)=>(
                    <Link key={key} to={`/cows/${item.ID}`} onClick={()=>setSearch(false)}><span>{item.Tag}</span> <span>{item.BuyDate}</span> <span>{item.HerdsMan}</span></Link>
                ))}
            </div>
        )
    }
    //TODO: This still needs a bunch of work the UI is pretty rough but it is a working version now
    return (
        <div className='search'>
            {Search && 
                <p className="searchClose" onClick={()=>setSearch(false)}>X</p>
            }
            <input type="search" className='searchInput' onKeyUp={searchCatch}  placeholder='Search'/>
            {Search && 
                <SearchOut data={Search.Data}/>
            }
        </div>
    )
}

export default Search
