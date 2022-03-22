

function Home() {
    return (
        <>
            <h1>Welcome {localStorage.getItem('User') && localStorage.getItem('User').split('@')[0]}</h1>
        </>
    )
}

export default Home
