import { useState, useRef } from "react"
import { Link } from "react-router-dom"

function Search() {
    const [ Search, setSearch ] = useState(false)
    const searchRef = useRef();
    const itemsRef = useRef();

    const searchCatch =  async (e) =>{
        let val = e.target.value
        if(val && val !== ' ' && val !== '%' && val !== '#'){
            fetch(process.env.REACT_APP_API_URL+'/cattle/search/'+val+'?limit=10',{
                headers:{
                    'Authorization': 'Bearer '+localStorage.getItem('Token')
                  }
            })
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
            <div className="searchItems" ref={itemsRef}>
                {data.map((item, key)=>(
                    <Link key={key} to={`/cows/${item.ID}`} onClick={()=>setSearch(false)}><span>{item.Tag}</span> <span>{item.StartDate}</span> <span>{item.HerdsMan}</span></Link>
                ))}
            </div>
        )
    }
    const clickClose = () => {
        setSearch(false)
        searchRef.current.value = ''
    }

    const handleBlur = (e) =>{
        if(!e.relatedTarget){
            setSearch(false)
            searchRef.current.value = ''
        }

    }
    //TODO: This still needs a bunch of work the UI is pretty rough but it is a working version now
    return (
        <div className='search'>
            {Search && 
                <p className="searchClose" onClick={clickClose}>X</p>
            }
            <input type="search" className='searchInput' ref={searchRef} onBlur={handleBlur} onKeyUp={searchCatch}  placeholder='Search'/>
            {Search && 
                <SearchOut data={Search.Data}/>
            }
        </div>
    )
}

export default Search
